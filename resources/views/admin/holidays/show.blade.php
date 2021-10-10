@extends('layouts.admin')

@section('content')
@can('holiday_show')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.holiday.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.holidays.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.holiday.fields.title') }}
                        </th>
                        <td>
                            {{ $holiday->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holiday.fields.commencement_date') }}
                        </th>
                        <td>
                            {{ $holiday->commencement_date ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holiday.fields.resumption_date') }}
                        </th>
                        <td>
                            {{ $holiday->resumption_date ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.holiday.fields.year') }}
                        </th>
                        <td>
                            {{ $holiday->year ?? ''}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <!-- <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.holidays.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

@endcan
@endsection
