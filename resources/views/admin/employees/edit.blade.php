@extends('layouts.admin')

@section('content')
@can('employee_edit')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="empId">{{ trans('cruds.employee.fields.empId') }}</label>
                <input class="form-control @error('empId') form-control-danger @enderror" type="text" name="empId" id="empId" value="{{ old('empId', $employee->empId) }}" required>
                @error('empId')
                    <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.empId_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="first_name">{{ trans('cruds.employee.fields.first_name') }}</label>
                <input class="form-control @error('first_name') form-control-danger @enderror" type="text" name="first_name" id="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                @error('first_name')
                    <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.first_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="last_name">{{ trans('cruds.employee.fields.last_name') }}</label>
                <input class="form-control @error('last_name') form-control-danger @enderror" type="text" name="last_name" id="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                @error('last_name')
                    <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.last_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gender">{{ trans('cruds.employee.fields.gender') }}</label>
                <input class="form-control @error('gender') form-control-danger @enderror" type="text" name="gender" id="gender" value="{{ old('gender', $employee->gender) }}" required>
                @error('gender')
                    <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.gender_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="eligible_leave">{{ trans('cruds.employee.fields.eligible') }}</label>
                <input class="form-control @error('eligible_leave') form-control-danger @enderror" type="text" name="eligible_leave" id="eligible_leave" value="{{ old('eligible_leave', $employee->eligible_leave) }}" required>
                @error('eligible_leave')
                    <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.eligible_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="hire_date">{{ trans('cruds.employee.fields.hire_date') }}</label>
                <input class="form-control date @error('hire_date') form-control-danger @enderror" type="text" name="hire_date" id="hire_date" value="{{ old('hire_date', $employee->hire_date ) }}">
                @error('hire_date')
                    <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.hire_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="position_id">{{ trans('cruds.employee.fields.position') }}</label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('position_id') form-control-danger @enderror" name="position_id" id="position_id" data-width="100%" aria-hidden="true" required>
                    <option value="">--- Choose Position ---</option>
                    @foreach ($positions as $id => $position)
                        <option value="{{ $id }}" {{ old('position_id', $employee->position_id) == $id ? 'selected' : '' }}>{{ $position }}</option>
                    @endforeach
                </select>
                @error('position')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.position_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.employee.fields.user') }}</label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('user_id') form-control-danger @enderror" name="user_id" id="user_id" data-width="100%" aria-hidden="true" required>
                    <option value="">--- Choose User ---</option>
                    @foreach ($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id', $employee->user_id) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @error('user')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
                <span class="help-block">{{ trans('cruds.employee.fields.user_helper') }}</span>
            </div>
            
            <div class="form-group">
                <button class="btn float-right btn-success"  type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endcan
@endsection

@section('scripts')
@parent
{!! JsValidator::formRequest('App\Http\Requests\Employee\UpdateEmployeeRequest') !!}
@endsection