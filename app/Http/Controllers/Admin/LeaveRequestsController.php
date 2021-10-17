<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Department;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\LeaveRequest\StoreLeaveRequestRequest;

class LeaveRequestsController extends Controller
{
    use MediaUploadingTrait; 
    
    public function index()
    {
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])->get();

        return view('admin.leaveRequests.index', compact('leaveRequests'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $id = auth()->user()->id;
        
        $employee = Employee::where('user_id', $id)->first();

        $employees = Employee::where('id', '!=', $id)->get();

        $leaveTypes = LeaveType::pluck('title', 'id');

        return view('admin.leaveRequests.create', compact('employee', 'leaveTypes', 'employees'));
    }

    public function store(StoreLeaveRequestRequest $request)
    {
        $employee = Employee::with(['department', 'lineManager'])->where('id', $request->employee_id)->first();
        
        if(empty($employee->lineManager)){
            $department = Department::with('lineManager')->where('id', $employee->department->id)->first();
            
            $lineManagerUser = Employee::with('user')->where('id', $department->lineManager->employee_id)->first();
        }
        elseif(!empty($employee->lineManager)){
            $headDepartment = Department::with(['parent'])->where('id', $employee->department->id)->first();
            
            $headDepartment->parent->load(['lineManager']);
            
            $lineManagerUser = Employee::with('user')->where('id', $headDepartment->parent->lineManager->employee_id)->first();
        }
        
        $leaveRequest = LeaveRequest::create($request->validated());

        foreach ($request->input('attachments', []) as $file) {
            $leaveRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('attachments');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $leaveRequest->id]);
        }

        $route = route('admin.leaveRequests.firstApprove', $leaveRequest);

        $details = [
            'employee' => $employee->first_name.' '.$employee->last_name,
            'commencement_date' => $request->commencement_date,
            'resumption_date' => $request->resumption_date,
            'reason' => $request->reason,
            'link' => $route,
        ];
       
        \Mail::to($lineManagerUser->user->email)->send(new \App\Mail\LeaveRequestMail($details));

        return redirect()->route('admin.leaveRequests.record')
            ->with('success', 'Leave Request has been request successfully.');
    }

    public function show(LeaveRequest $leaveRequest)
    {
        abort_if(Gate::denies('leave_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveRequests.show', compact('leaveRequest'));
    }

    public function edit(LeaveRequest $leaveRequest)
    {
        abort_if(Gate::denies('leave_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee = Employee::findOrfail(auth()->user()->id);

        $leaveTypes = LeaveType::pluck('title', 'id');

        return view('admin.leaveRequests.edit', compact('employee', 'leaveTypes', 'leaveRequest'));
    }

    public function update(StoreLeaveRequestRequest $request, LeaveRequest $leaveRequest)
    {
        $leaveRequest->update($request->validated());

        return redirect()->route('admin.leaveRequests.index')
            ->with('success', 'Leave Request has been update successfully.');
    }

    public function destroy(LeaveRequest $leaveRequest)
    {
        abort_if(Gate::denies('leave_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRequest->delete();

        return back();
    }

    public function MassDestroy(MassDestroyLeaveRequestRequest $request)
    {
        LeaveRequest::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function firstApprove(LeaveRequest $leaveRequest)
    {
        abort_if(Gate::denies('leaveRequest_reviewer'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee = Employee::findOrfail($leaveRequest->employee_id);

        $leaveRequest->load(['leaveType']);

        return view('admin.leaveRequests.approvals.first_approve', compact('leaveRequest', 'employee'));
    }

    public function firstApproveUpdate(Request $request, $id)
    {
        abort_if(Gate::denies('leaveRequest_reviewer'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $leaveRequest = LeaveRequest::findOrfail($id);
        
        $employee = Employee::findOrfail($leaveRequest->employee_id);
        
        if ( $request->action == 'approve' ) {
            if(empty($employee->lineManager)){
                $department = Department::with('lineManager')->where('id', $employee->department->id)->first();
                
                $firstlineManager = Employee::with('lineManager')->where('id', $department->lineManager->employee_id)->first();
            }
            elseif(!empty($employee->lineManager)){
                $headDepartment = Department::with(['parent'])->where('id', $employee->department->id)->first();
                
                $headDepartment->parent->load(['lineManager']);
                
                $firstlineManager = Employee::with('lineManager')->where('id', $headDepartment->parent->lineManager->employee_id)->first();
            }

            try {
                $headDepartmentLineManager =  Department::with(['parent'])->where('id', $firstlineManager->department->id)->first();
                
                $parentDep = $headDepartmentLineManager->parent;

                if(!empty($parentDep))
                {
                    $parentDep->load(['lineManager']);
    
                    $parentDepLineManager = $parentDep->lineManager;
    
                    $parentDepLineManager->load(['employee']);
    
                    $employeeAssecondLineManager = $parentDepLineManager->employee;
    
                    $employeeAssecondLineManager->load(['user']);
                    
                    $email = $employeeAssecondLineManager->user->email;
                }else{
                    // The after last Employee (COO to CEO) spacial condition
                    $now = now();
                    $leaveRequest->update(['status' => '2', 'approved_at' => $now]);

                    $leaveRequest->user()->associate($request->reviewedBy)->save();

                }
                
            }catch(e){
                return e;
            }

            dd($email);
            
            $now = now();
            $leaveRequest->update(['status' => '1', 'reviewed_at' => $now]);

            $leaveRequest->user()->associate($request->reviewedBy)->save();

            $route = route('admin.leaveRequests.secondApprove', $leaveRequest);

            $details = [
                'employee' => $employee->first_name.' '.$employee->last_name,
                'commencement_date' => $leaveRequest->commencement_date,
                'resumption_date' => $leaveRequest->resumption_date,
                'reason' => $leaveRequest->reason,
                'link' => $route,
            ];
           
            \Mail::to($email)->send(new \App\Mail\LeaveRequestMail($details));
            
        }elseif ( $request->action == 'reject' ) {
            $now = now();
            $leaveRequest->update(['status' => '4', 'reviewed_at' => $now]);

            $leaveRequest->user()->associate($request->reviewedBy)->save();

            $route = route('admin.leaveRequests.secondApprove', $leaveRequest);
            
        }else{
            return response('Opps', 200);
        }

        return response('success', 200);
    }

    public function secondApprove(leaveRequest $leaveRequest)
    {
        abort_if(Gate::denies('leaveRequest_approver'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRequest->load(['user']);

        $employee = Employee::findOrfail($leaveRequest->employee_id);

        return view('admin.leaveRequests.approvals.second_approve', compact('leaveRequest', 'employee'));
    }

    public function secondApproveUpdate(Request $request, $id)
    {
        abort_if(Gate::denies('leaveRequest_approver'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRequest = leaveRequest::findOrfail($id);

        if ($request->action == 'approve') {
            $now = now();
            
            $employee = Employee::findOrfail($leaveRequest->employee_id);
            
            $newEligible = $employee->eligible_leave - $leaveRequest->no_of_day;
            
            if($employee->eligible_leave > 0 && $newEligible > 0){
                
                $employee->update(['eligible_leave' => $newEligible]);
                
            }elseif($employee->eligible = 0 || $newEligible <= 0){
                
                $employee->update(['eligible_leave' => 0, 'leave_taken' => abs($newEligible)]);
                
            }
            
            $leaveRequest->update(['status' => '2', 'approved_at' => $now]);

        }elseif($request->action == 'reject'){

            $leaveRequest->update(['status' => '4']);
            
        }else{
            return response('Opss', 402);
        }
        return response('success', 200);
    }

    public function record()
    {
        abort_if(Gate::denies('leave_request_record'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        auth()->user()->load(['employee']);

        $leaveRequests = [];

        if(!empty(auth()->user()->employee)){

            $employee = auth()->user()->employee;

            $employee->load(['leaveRequests']);

            $leaveRequests = $employee->leaveRequests;
        }
        
        return view('admin.leaveRequests.record', compact('leaveRequests'));
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('leave_request_create') && Gate::denies('leave_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new LeaveRequest();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
