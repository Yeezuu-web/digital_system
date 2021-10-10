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
        LineManager::create($request->validated());

        return redirect()->route('admin.lineManagers.index')
            ->with('success', 'Line Manager has been create successfully.');
    }

    public function show(LineManager $lineManager)
    {
        abort_if(Gate::denies('line_manager_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.lineManagers.show', compact('lineManager'));
    }

    public function edit(LineManager $lineManager)
    {
        abort_if(Gate::denies('line_manager_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::all();
        $departments = Department::pluck('title', 'id');

        return view('admin.lineManagers.edit', compact('employees', 'departments', 'lineManager'));
    }

    public function update(UpdateLineManagerRequest $request, LineManager $lineManager)
    {
        $lineManager->update($request->validated());

        return redirect()->route('admin.lineManagers.index')
            ->with('success', 'Line Manager has been update successfully.');
    }

    public function destroy(LineManager $lineManager)
    {
        abort_if(Gate::denies('line_manager_destroy'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $lineManager->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function massDestroy(MassDestroyLineManagerRequest $request)
    {
        LineManager::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
