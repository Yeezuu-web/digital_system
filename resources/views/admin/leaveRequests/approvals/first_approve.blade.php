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
        {{ trans('cruds.leaveRequest.title_singular') }} For First Approve
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <h5 class="mb-2">Request info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td width="30">Employee</td>
                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        </tr>
                        <tr>
                            <td width="30">Employee ID</td>
                            <td>{{ $employee->empId }}</td>
                        </tr>
                        <tr>
                            <td width="30">Commencement Date</td>
                            <td>{{ $leaveRequest->commencement_date }}</td>
                        </tr>
                        <tr>
                            <td width="30">Resumption Date</td>
                            <td>{{ $leaveRequest->resumption_date }}</td>
                        </tr>
                        <tr>
                            <td width="30">No of day</td>
                            <td>{{ $leaveRequest->no_of_day }}</td>
                        </tr>
                        <tr>
                            <td width="30">Reason</td>
                            <td>{{ $leaveRequest->reason }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-3">
                @csrf
                @if ($leaveRequest->status == '0')
                    <button type="button" class="btn btn-danger float-lg-right btn-load" onclick="reject({{ $leaveRequest->id }}, 'reject', {{ auth()->user()->id }})">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Reject
                    </button>
                    <button type="button" class="btn btn-success mr-3 float-lg-right btn-load" onclick="approve({{ $leaveRequest->id }}, 'approve', {{ auth()->user()->id }})">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Approve
                    </button>
                @elseif($leaveRequest->status == '1' || $leaveRequest->status == '2' || $leaveRequest->status == '3')
                    <button type="button" class="btn btn-secondary float-lg-right" disabled>
                        Approved
                    </button>
                @elseif($leaveRequest->status == '4')
                    <button type="button" class="btn btn-danger float-lg-right btn-load" disabled>
                        Rejected
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
    approve = (id, action, user) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/system/admin/leaveRequests/firstApprove/update/" + id, // on production
            // url: "/admin/leaveRequests/firstApprove/update/" + id, // on development
            data: {
                _token: _token,
                action: action,
                id: id,
                reviewedBy: user
            },
            beforeSend: () => {
                $('.spinner-border').removeAttr('hidden');
                $('.btn-load').attr('disabled', 'true');
            },
            success: function (response) {
                if(response == 'success'){
                    Swal.fire({
                        title: 'Reveiwed',
                        text: "The request has been reviewed.",
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
                    $('.spinner-border').hide();
                    $('.btn-load').removeAttr('disabled');
                }
            },
            complete: () => {
                $('.btn-load').children().hide();
                $('.btn-load').removeAttr('disabled');
            }
        });
    }

    reject = (id, action, user) => {
        let _token = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: "/system/admin/leaveRequests/firstApprove/update/" + id, // on production
            // url: "/admin/leaveRequests/firstApprove/update/" + id, // on development
            data: {
                _token: _token,
                action: action,
                reviewedBy: user,
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
