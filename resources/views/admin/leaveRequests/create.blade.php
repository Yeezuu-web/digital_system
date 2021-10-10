@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-secondary" href="{{ route("admin.leaveRequests.index") }}">
        {{ trans('global.back') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.leaveRequest.title_singular') }}
    </div>
    <div class="card-body">
        <form action="{{ route("admin.leaveRequests.store") }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="employee_id" class="required">{{ trans('cruds.leaveRequest.fields.employee')}} <span class="text-danger">*</span></label>
                <select class="form-control @error('employee_id') form-control-danger @enderror" name="employee_id" id="employee_id" required>
                    <option value="{{ $employee->id }}" selected>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                </select>
                @error('employee_id')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="leave_type_id" class="required">{{ trans('cruds.leaveRequest.fields.leave_type')}} <span class="text-danger">*</span></label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('leave_type_id') form-control-danger @enderror" name="leave_type_id" data-width="100%" aria-hidden="true">
                    <option value=""​>--- Choose leave type ---</option>
                    @foreach ($leaveTypes as $id => $leaveType)
                        <option value="{{ $id }}"​>{{ $leaveType }}</option>
                    @endforeach
                </select>
                @error('leave_type_id')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
            </div>

            {{-- <div class="form-group">
                <label for="leave_type_id" class="required">{{ trans('cruds.leaveRequest.fields.leave_type')}} <span class="text-danger">*</span></label>
                @foreach ($leaveTypes as $id => $leaveType)
                    <div class="form-check ml-2">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="leave_type_id" id="leave_type_id{{ $id }}" value="{{ $id }}">
                            {{ $leaveType }}
                        <i class="input-frame"></i></label>
                    </div>
                @endforeach
                @error('leave_type_id')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
            </div> --}}

            <div class="form-group">
                <label for="commencement_date" class="required">{{ trans('cruds.leaveRequest.fields.commencement_date')}} <span class="text-danger">*</span></label>
                <input class="form-control date @error('commencement_date') form-control-danger @enderror" type="text" name="commencement_date" id="commencement_date" value="{{ old('commencement_date', '') }}" required>
                @error('commencement_date')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="resumption_date" class="required">{{ trans('cruds.leaveRequest.fields.resumption_date')}} <span class="text-danger">*</span></label>
                <input class="form-control date @error('resumption_date') form-control-danger @enderror" type="text" name="resumption_date" id="resumption_date" value="{{ old('resumption_date', '') }}" required>
                @error('resumption_date')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_of_day" class="required">{{ trans('cruds.leaveRequest.fields.no_of_day')}} <span class="text-danger">*</span></label>
                <input class="form-control @error('no_of_day') form-control-danger @enderror" type="number" min="0" name="no_of_day" id="no_of_day" value="{{ old('no_of_day', '') }}" required>
                @error('no_of_day')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="reason" class="required">{{ trans('cruds.leaveRequest.fields.reason')}} <span class="text-danger">*</span> </label>
                <textarea class="form-control @error('reason') form-control-danger @enderror" type="text" name="reason" id="reason" rows="5" value="{{ old('reason', '') }}" required>
                </textarea>
                @error('reason')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@parent
{!! JsValidator::formRequest('App\Http\Requests\leaveRequest\StoreleaveRequestRequest') !!}
@endsection