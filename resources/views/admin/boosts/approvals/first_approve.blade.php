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
        {{ trans('cruds.boost.title_singular') }} Request For Review
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="mb-2">Client info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Requester Name</td>
                            <td>{{ $boost->requester_name }}</td>
                        </tr>
                        <tr>
                            <td>Client Name</td>
                            <td>{{ $boost->company_name }}</td>
                        </tr>
                        <tr>
                            <td>Group</td>
                            <td>{{ $boost->group }}</td>
                        </tr>
                        <tr>
                            <td>Budget</td>
                            <td>$ {{ $boost->budget }}</td>
                        </tr>
                        <tr>
                            <td>Reference</td>
                            <td>
                                @if ($boost->reference)
                                    <a href="{{ $boost->reference->url }}" target="_blank" rel="noopener noreferrer">
                                        <img src="{{ $boost->reference->thumbnail }}" alt="reference">
                                    </a>
                                @else
                                    no image...
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="mb-2">Boost info</h5>
                <table class="table table-bordered table-striped table-hover">
                    <tbody>
                        <tr>
                            <td>Product/Program/Brand</td>
                            <td>{{ $boost->program_name ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Target URL</td>
                            <td>{{ $boost->target_url ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Boost Start</td>
                            <td>{{ $boost->boost_start ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Boost End</td>
                            <td>{{ $boost->boost_end ?? ''}}</td>
                        </tr>
                        <tr>
                            <td>Target Channel</td>
                            <td style="padding: 3px 3px 3px 15px;">
                                @foreach ($boost->channels as $channel)
                                    <span class="badge badge-success badge-sm">{{ $channel->title }}</span>
                                @endforeach
                            </td>
                        </tr>
                        <tr>
                            <td>Reason For Boosting</td>
                            <td>{{ $boost->reason ?? ''}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12 mt-3">
                @csrf
                @if ($boost->status == '0')
                    <button type="button" class="btn btn-danger float-lg-right btn-load" onclick="reject({{ $boost->id }}, 'reject', {{ auth()->user()->id }})">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Reject
                    </button>
                    <button type="button" class="btn btn-success mr-3 float-lg-right btn-load" onclick="approve({{ $boost->id }}, 'approve', {{ auth()->user()->id }})">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                        Review
                    </button>
                @elseif($boost->status == '1' || $boost->status == '2' || $boost->status == '3')
                    <button type="button" class="btn btn-secondary float-lg-right" disabled>
                        Reviewed
                    </button>
                @elseif($boost->status == '4')
                    <button type="button" class="btn btn-danger float-lg-right btn-load" disabled>
                        Rejected
                    </button>
                @elseif($boost->status == '5')
                    <button type="button" class="btn btn-secondary float-lg-right btn-load" disabled>
                        Completed
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
            url: "/system/admin/boosts/firstApprove/update/" + id,
            data: {
                _token: _token,
                action: action,
                id: id,
                user: user
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
                            location.href = "/system/admin/boosts";
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
            url: "/system/admin/boosts/firstApprove/update/" + id,
            data: {
                _token: _token,
                action: action,
                user: user,
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
                            location.href = "/system/admin/boosts";
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
