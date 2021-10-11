@extends('layouts.admin')
@section('styles')
    <style>
        .table td img {
            width: 80px;
            height: 80px;
            border-radius: 0%;
        }
    </style>
@endsection
@section('content')
@include('partials.flash-message')
<div class="card">
    <div class="card-header">
        {{ trans('cruds.leaveRequest.title_singular') }} Request For Approval
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-2">Request info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td width="30">Employee</td>
                            <td>{{ $employee->first_name ?? ''}} {{ $employee->last_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Employee ID</td>
                            <td>{{ $employee->empId ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Commencement Date</td>
                            <td>{{ $leaveRequest->commencement_date ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Resumption Date</td>
                            <td>{{ $leaveRequest->resumption_date ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">No of day</td>
                            <td>{{ $leaveRequest->no_of_day ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">Reason</td>
                            <td>{{ $leaveRequest->reason ?? ''}}</td>
                        </tr>
                        <tr>
                            <td width="30">First Approve By</td>
                            <td>{{ $leaveRequest->user->name ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-3">
                @csrf
                @if ($leaveRequest->status == '1')
                    <button type="button" class="btn btn-danger float-lg-right btn-load" onclick="reject({{ $leaveRequest->id }}, 'reject')">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Reject
                    </button>
                    <button type="button" class="btn btn-success mr-3 float-lg-right btn-load" onclick="approve({{ $leaveRequest->id }}, 'approve')">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Approve
                    </button>
                @elseif($leaveRequest->status == '0')
                    <button type="button" class="btn btn-success float-lg-right" disabled>
                        In Review
                    </button>
                @elseif($leaveRequest->status == '4')
                    <button type="button" class="btn btn-danger float-lg-right" disabled>
                        Rejected
                    </button>
                @elseif($leaveRequest->status == '5')
                    <button type="button" class="btn btn-secondary float-lg-right" disabled>
                        Completed
                    </button>
                @elseif($leaveRequest->status == '2' || $leaveRequest->status == '3')
                    <button type="button" class="btn btn-secondary float-lg-right" disabled>
                        Approved
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
    $(document).ready(function () {
        $('.btn-load').children().hide();
    });

    approve = (id, action) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/system/admin/leaveRequests/secondApprove/update/" + id, // on production
            // url: "/admin/leaveRequests/secondApprove/update/" + id, // on developement
            data: {
                _token: _token,
                action: action,
                id: id
            },
            beforeSend: () => {
                $('.btn-load').children().show();
                $('.btn-load').attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire({
                        title: 'Approved',
                        text: "The request has been approved.",
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Done',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "/system/admin/leaveRequests";
                        }
                    })
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                    $('.btn-load').children().hide();
                    $('.btn-load').removeAttr('disabled');
                }
            },
            complete: () => {
                $('.btn-load').children().hide();
                $('.btn-load').removeAttr('disabled');
            }
        });
    }

    reject = (id, action) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/system/admin/leaveRequests/secondApprove/update/" + id, // on production
            // url: "/admin/leaveRequests/secondApprove/update/" + id, // on development
            data: {
                _token: _token,
                action: action,
                id: id
            },
            beforeSend: () => {
                $('.btn-load').children().show();
                $('.btn-load').attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire({
                        title: 'Rejected',
                        text: "The request has been rejected.",
                        icon: 'warning',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Done',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "/system/admin/leaveRequests";
                        }
                    })
                }
                if(response == 'Opss') {
                    Swal.fire(
                        response,
                        'Something on occure',
                        'error'
                    );
                    $('.btn-load').children().hide();
                    $('.btn-load').removeAttr('disabled');
                }
            },
            complete: () => {
                $('.btn-load').children().hide();
                $('.btn-load').removeAttr('disabled');
            }
        });
    }
</script>
@endsection
