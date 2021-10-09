<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Employee;
use App\Models\Department;
use App\Models\LineManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\LineManager\StoreLineManagerRequest;
use App\Http\Requests\LineManager\UpdateLineManagerRequest;
use App\Http\Requests\LineManager\MassDestroyLineManagerRequest;

class LineManagersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('line_manager_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lineManagers = lineManager::with(['employee', 'department'])->get();

        return view('admin.lineManagers.index', compact('lineManagers'));
    }

    public function create()
    {
        abort_if(Gate::denies('line_manager_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::all();
        $departments = Department::pluck('title', 'id');

        return view('admin.lineManagers.create', compact('employees', 'departments'));
    }

    public function store(StoreLineManagerRequest $request)
    {
        //
    }

    public function show(LineManager $lineManager)
    {
        //
    }

    public function edit(LineManager $lineManager)
    {
        //
    }

    public function update(UpdateLineManagerRequest $request, LineManager $lineManager)
    {
        //
    }

    public function destroy(LineManager $lineManager)
    {
        //
    }

    public function massDestroy(MassDestroyLineManagerRequest $request)
    {
        //
    }
}
