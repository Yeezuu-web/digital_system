<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\LeaveRequest\StoreLeaveRequestRequest;

class LeaveRequestsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leave_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])->get();

        return view('admin.leaveRequests.index', compact('leaveRequests'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee = Employee::find(auth()->user()->id);

        $leaveTypes = LeaveType::pluck('title', 'id');

        return view('admin.leaveRequests.create', compact('employee', 'leaveTypes'));
    }

    public function store(StoreLeaveRequestRequest $request)
    {
        $employee = Employee::find($request->employee_id);

        if(isset($employee)){
            $eligible = $employee->eligible_leave;
            $newEligible = $eligible - $request->no_of_day;

            if($eligible > 0 && $newEligible > 0){
                $employee->update(['eligible_leave' => $newEligible]);
            }elseif($newEligible <= 0){
                $employee->update(['eligible_leave' => '0', 'leave_taken' => abs($newEligible)]);
            }
        }

        LeaveRequest::create($request->validated());

        return redirect()->route('admin.leaveRequests.index')
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

        $employee = Employee::find(auth()->user()->id);

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
}
