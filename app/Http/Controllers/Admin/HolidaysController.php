<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Holiday\StoreHolidayRequest;
use App\Http\Requests\Holiday\MassDestroyHolidayRequest;

class HolidaysController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('holiday_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $holidays = Holiday::all();

        $holidays = Holiday::whereYear('year', date('Y'))->get();

        return view('admin.holidays.index', compact('holidays'));
    }

    public function create()
    {
        abort_if(Gate::denies('holiday_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.holidays.create');
    }

    public function store(StoreHolidayRequest $request)
    {
        $input = $request->validated();

        if (!empty($input['dates'])) {
            $input['dates'] = array_filter($input['dates'], static function ($item) {
                return !empty($item);
            });

            $input['dates'] = array_unique($input['dates']);
        }

        Holiday::create($input);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday has been create successfully.');
    }

    public function show(Holiday $holiday)
    {
        abort_if(Gate::denies('holiday_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.holidays.show', compact('holiday'));
    }

    public function edit(Holiday $holiday)
    {
        abort_if(Gate::denies('holiday_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.holidays.edit', compact('holiday'));
    }

    public function update(StoreHolidayRequest $request, Holiday $holiday)
    {
        $holiday->update($request->validated());

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday has been update successfully.');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();

        return back();
    }

    public function MassDestroy(MassDestroyHolidayRequest $request) 
    {
        Holiday::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
