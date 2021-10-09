@extends('layouts.admin')

@section('content')
@can('line_manager_show')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.lineManager.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.lineManagers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.lineManager.fields.lineManager') }}
                        </th>
                        <td>
                            {{ $lineManager->employee->first_name ?? '' }} {{ $lineManager->employee->last_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lineManager.fields.head') }}
                        </th>
                        <td>
                            {{ $lineManager->department->title ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.lineManager.fields.remark') }}
                        </th>
                        <td>
                            {{ $lineManager->remark ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <!-- <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.lineManagers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

@endcan
@endsection
