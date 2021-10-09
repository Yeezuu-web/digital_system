@extends('layouts.admin')

@section('content')
@can('line_manager_edit')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.lineManager.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.lineManagers.update", [$lineManager->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            
            <div class="form-group">
                <label for="employee_id" class="required">{{ trans('cruds.lineManager.fields.department_head')}}</label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible {{ $errors->has('employee_id') ? 'is-invalid' : '' }}" name="employee_id" data-width="100%" aria-hidden="true">
                    <option value=""​>--- Choose Employee ---</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}"​ {{ old('employee_id', $lineManager->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee_id'))
                    <span class="text-danger">{{ $errors->first('employee_id') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee_id" class="required">{{ trans('cruds.lineManager.fields.lineManager')}}</label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible {{ $errors->has('department_id') ? 'is-invalid' : '' }}" name="department_id" data-width="100%" aria-hidden="true">
                    <option value=""​>--- Choose Department ---</option>
                    @foreach ($departments as $id => $department)
                        <option value="{{ $id }}"​ {{ old('department_id', $lineManager->department_id) == $id ? 'selected' : '' }}>{{ $department }}</option>
                    @endforeach
                </select>
                @if($errors->has('department_id'))
                    <span class="text-danger">{{ $errors->first('department_id') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="remark" class="required">{{ trans('cruds.lineManager.fields.remark')}}</label>
                <input class="form-control {{ $errors->has('remark') ? 'is-invalid' : '' }}" type="text" name="remark" id="remark" value="{{ old('remark', $lineManager->remark) }}">
                @if($errors->has('remark'))
                <span class="text-danger">{{ $errors->first('remark') }}</span>
                @endif
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
{!! JsValidator::formRequest('App\Http\Requests\lineManager\UpdatelineManagerRequest') !!}
@endsection