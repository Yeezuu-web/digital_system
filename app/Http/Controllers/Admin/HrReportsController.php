<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class HrReportsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leaveRequest_approver'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        return view('admin.hr.report');
    }
}
