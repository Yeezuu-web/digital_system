@extends('layouts.admin')

@section('content')
@can('leave_type_edit')

@include('partials.flash-message')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.leaveType.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leaveTypes.update", [$leaveType->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            
            <div class="form-group">
                <label for="title" class="required">{{ trans('cruds.leaveType.fields.title')}}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $leaveType->title) }}" required>
                @if($errors->has('title'))
                <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
            </div>
            <div class="form-group">
                <label for="default_dur" class="required">{{ trans('cruds.leaveType.fields.default_dur')}}</label>
                <input class="form-control {{ $errors->has('default_dur') ? 'is-invalid' : '' }}" type="text" name="default_dur" id="default_dur" value="{{ old('default_dur', $leaveType->default_dur) }}" required>
                @if($errors->has('default_dur'))
                <span class="text-danger">{{ $errors->first('default_dur') }}</span>
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
{!! JsValidator::formRequest('App\Http\Requests\LeaveType\UpdateLeaveTypeRequest') !!}
@endsection