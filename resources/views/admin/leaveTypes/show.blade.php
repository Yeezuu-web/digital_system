@extends('layouts.admin')

@section('content')
@can('leave_type_show')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.leaveType.title_singular') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.leaveTypes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveType.fields.title') }}
                        </th>
                        <td>
                            {{ $leaveType->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveType.fields.default_dur') }}
                        </th>
                        <td>
                            {{ $leaveType->default_dur ?? ''}}
                        </td>
                    </tr>
                </tbody>
            </table>
            <br>
            <!-- <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.leaveTypes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

@endcan
@endsection
