@extends('layouts.admin')

@section('content')
@can('leave_request_record')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        Your Leave Record
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="30">#</th>
                            <th>Commencement Date</th>
                            <th>Resumption Date</th>
                            <th>No of Day</th>
                            <th>Reason</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    @if (empty($leaveRequests))
                        <tbody>
                            <tr>
                                <td colspan="6">
                                    <p class="text-center">No leave record...</p>
                                </td>
                            </tr>
                        </tbody>
                    @else    
                        <tbody>
                            @foreach ($leaveRequests as $leaveRequest)  
                                <tr>
                                    <td>{{ $leaveRequest->id }}</td>
                                    <td>{{ $leaveRequest->commencement_date }}</td>
                                    <td>{{ $leaveRequest->resumption_date }}</td>
                                    <td>{{ $leaveRequest->no_of_day }} {{ $leaveRequest->no_of_day ? 'day(s)' : '' }}</td>
                                    <td>{{ $leaveRequest->reason }}</td>
                                    <td>
                                        @if ($leaveRequest->status == '0')
                                            <span class="badge badge-success">In Review</span>
                                        @elseif ($leaveRequest->status == '1')
                                            <span class="badge badge-warning">First Approved</span>
                                        @elseif ($leaveRequest->status == '2')
                                            <span class="badge badge-success">Approved</span>
                                        @else
                                            <span class="badge badge-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
            <br>
            <!-- <div class="form-group">
                <a class="btn btn-success" href="{{ route('admin.employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div> -->
        </div>
    </div>
</div>

@endcan
@endsection

@section('scripts')
@parent
@endsection