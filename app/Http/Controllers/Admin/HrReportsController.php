<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class HrReportsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leaveRequest_approver'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveRequests = LeaveRequest::with(['employee', 'leaveType'])->where('status', 2)->get();

        return view('admin.hr.report', compact('leaveRequests'));
    }
}
