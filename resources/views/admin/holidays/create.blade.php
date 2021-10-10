@extends('layouts.admin')
@section('styles')
    <style>
        .datepicker table {
            width: 100%;
            margin: 0 auto;
        }
    </style>
@endsection
@section('content')
@include('partials.flash-message')
<div class="form-group">
    <a class="btn btn-secondary" href="{{ route('admin.holidays.index') }}">
        {{ trans('global.back') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.holiday.title_singular') }}
    </div>
    <div class="card-body">
        <form action="{{ route("admin.holidays.store") }}" method="POST" autocomplete="off">
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('cruds.holiday.fields.title') }}</label>
                <input class="form-control @error('title') form-control-danger @enderror" type="text" name="title" id="title" required>
                @error('title')
                    <label id="title-error" class="error mt-2 text-danger" for="title">{{ $message }}</label>
                @enderror
            </div>
            <div class="input_fields_wrap">
                <label for="title">{{ trans('cruds.holiday.fields.dates') }}</label>
                @foreach(old('dates', isset($holiday) ? $holiday->dates : []) as $key => $item)
                    <div class="form-group col-sm-2">
                        <input class="form-control date" name="dates[]" type="text" value="{{$item}}">
                    </div>
                @endforeach

            </div>
            <div class="col-sm-12">
                <button class="btn btn-link btn-sm add_field_button" type="button">+ Add</button>
            </div>
            <div class="form-group">
                <label for="year" class="required">{{ trans('cruds.holiday.fields.year')}}</label>
                <input class="form-control yearpicker @error('year') form-control-danger @enderror" type="text" name="year" id="year" value="{{ old('year', '') }}">
                @error('year')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
@parent
{!! JsValidator::formRequest('App\Http\Requests\Holiday\StoreHolidayRequest') !!}
<script>
    $('.yearpicker').datepicker({
      format: "yyyy",
      viewMode: "years", 
      minViewMode: "years",
      autoclose:true
    }); 
</script>
<script>
        $(document).ready(function() {
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                //add input box
                var template = '<div class="form-group"> <input class="form-control" name="dates[]" type="date"></div>';
                console.log(template);
                $(wrapper).append(template);
            });
        });
</script>
@endsection
