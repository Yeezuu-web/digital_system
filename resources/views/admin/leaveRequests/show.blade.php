@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.leaveReaquest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-secondary" href="{{ route('admin.leaveRequests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.employee') }}
                        </th>
                        <td>
                            {{ $leaveRequest->employee->first_name ?? '' }} {{ $leaveRequest->employee->last_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.leave_type') }}
                        </th>
                        <td>
                            {{ $leaveRequest->leaveType->title ?? ''}}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.commencement_date') }}
                        </th>
                        <td>
                            {{ $leaveRequest->commencement_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.resumption_date') }}
                        </th>
                        <td>
                            {{ $leaveRequest->resumption_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.no_of_day') }}
                        </th>
                        <td>
                            {{ $leaveRequest->no_of_day }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.cover_by') }}
                        </th>
                        <td>
                            {{ $leaveRequest->cover_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.reason') }}
                        </th>
                        <td>
                            {{ $leaveRequest->reason }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveRequest.fields.status') }}
                        </th>
                        <td>
                            @if ($leaveRequest->status == '0')
                                <span class="badge badge-info">In Review</span>
                            @elseif ($leaveRequest->status == '1')
                                <span class="badge badge-warning">First Approved</span>
                            @elseif ($leaveRequest->status == '2')
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-danger">Rejected</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-secondary" href="{{ route('admin.leaveRequests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

@endsection