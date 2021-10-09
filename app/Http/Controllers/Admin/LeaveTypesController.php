<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\LeaveType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\LeaveType\StoreLeaveTypeRequest;
use App\Http\Requests\LeaveType\UpdateLeaveTypeRequest;
use App\Http\Requests\LeaveType\MassDestroyLeaveTypeRequest;

class LeaveTypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leave_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveTypes = leaveType::all();

        return view('admin.leaveTypes.index', compact('leaveTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveTypes.create');
    }

    public function store(StoreLeaveTypeRequest $request)
    {
        LeaveType::create($request->all());

        return redirect()->route('admin.leaveTypes.index')
            ->with('success', 'Leave Type has been create successfully');
    }

    public function show(LeaveType $leaveType)
    {
        abort_if(Gate::denies('leave_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveTypes.show', compact('leaveType'));
    }

    public function edit(LeaveType $leaveType)
    {
        abort_if(Gate::denies('leave_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.leaveTypes.edit', compact('leaveType'));
    }

    public function update(UpdateLeaveTypeRequest $request, LeaveType $leaveType)
    {
        $leaveType->update($request->all());

        return redirect()->route('admin.leaveTypes.index')
            ->with('success', 'Leave Type has been update successfully');
    }

    public function destroy(LeaveType $leaveType)
    {
        abort_if(Gate::denies('department_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function MassDestroy(MassDestroyLeaveTypeRequest $request)
    {
        LeaveType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
