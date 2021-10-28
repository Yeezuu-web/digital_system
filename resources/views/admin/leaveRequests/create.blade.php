@extends('layouts.admin')
@section('content')
<div class="form-group">
    <a class="btn btn-secondary" href="{{ route("admin.leaveRequests.index") }}">
        {{ trans('global.back') }}
    </a>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.leaveRequest.title_singular') }} {{ trans('global.form') }} 
    </div>
    <div class="card-body">
        <form action="{{ route("admin.leaveRequests.store") }}" method="POST" autocomplete="off">
            @csrf
            @if(empty($employee))
            <div class="alert alert-danger" role="alert">
                <span>* Please assign your user to employee before make a request</span>
            </div>
            @endif
            @if(!empty($employee))
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.leaveRequest.fields.employee')}} <span class="text-danger">*</span></label>
                <select class="form-control @error('employee_id') form-control-danger @enderror" name="employee_id" id="employee_id" required>
                    <option value="{{ $employee->id }}" selected>{{ $employee->first_name }} {{ $employee->last_name }}</option>
                </select>
                @error('employee_id')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>
            @endif
                
            <div class="form-group">
                <label for="leave_type_id">{{ trans('cruds.leaveRequest.fields.leave_type')}} <span class="text-danger">*</span></label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('leave_type_id') form-control-danger @enderror" name="leave_type_id" id="leave_type_id" data-width="100%" aria-hidden="true">
                    <option value="">--- Choose leave type ---</option>
                    @foreach ($leaveTypes as $id => $leaveType)
                        <option value="{{ $id }}">{{ $leaveType }}</option>
                    @endforeach
                </select>
                @error('leave_type_id')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div class="form-group">
                <label for="commencement_date">{{ trans('cruds.leaveRequest.fields.commencement_date')}} <span class="text-danger">*</span></label>
                <input class="form-control datepicker @error('commencement_date') form-control-danger @enderror" type="text" name="commencement_date" id="commencement_date" value="{{ old('commencement_date', '') }}" required>
                @error('commencement_date')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="resumption_date">{{ trans('cruds.leaveRequest.fields.resumption_date')}} <span class="text-danger">*</span></label>
                <input class="form-control datepicker @error('resumption_date') form-control-danger @enderror" type="text" name="resumption_date" id="resumption_date" value="{{ old('resumption_date', '') }}" required>
                @error('resumption_date')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_of_day">{{ trans('cruds.leaveRequest.fields.no_of_day')}} <span class="text-danger">*</span></label>
                <input class="form-control @error('no_of_day') form-control-danger @enderror" type="number" min="0" name="no_of_day" id="no_of_day" value="{{ old('no_of_day', '') }}" required>
                @error('no_of_day')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" id="reason1">
                <label for="reason">{{ trans('cruds.leaveRequest.fields.reason')}}</label>
                <textarea class="form-control @error('reason') form-control-danger @enderror" type="text" name="reason" id="reason" rows="5" required></textarea>
                @error('reason')
                <span class="error mt-2 text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" id="reason2">
                <label for="reason">{{ trans('cruds.leaveRequest.fields.reason')}} <span class="text-danger">(Optional)</span></label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('reason') form-control-danger @enderror" name="reason" data-width="100%" aria-hidden="true">
                    <option value="">--- Choose reason for spacail leave ---</option>
                    <option value="Personal wedding">Personal wedding</option>
                    <option value="Paternity Obligation">Paternity Obligation</option>
                    <option value="Employee's own children Wedding">Employee's own children Wedding</option>
                    <option value="Bereavement">Bereavement</option>
                </select>
                @error('reason')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div class="form-group">
                <label for="cover_by">{{ trans('cruds.leaveRequest.fields.cover_by_long')}} <span class="text-danger">(Optional)</span></label>
                <select class="js-example-basic-single w-100 select2-hidden-accessible @error('cover_by') form-control-danger @enderror" name="cover_by" data-width="100%" aria-hidden="true">
                    <option value="">--- Choose Cover By ---</option>
                    @foreach ($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }}</option>
                    @endforeach
                </select>
                @error('cover_by')
                    <label class="error mt-2 text-danger">{{ $message }}</label>
                @enderror
            </div>

            <div class="form-group" id="upload-attach">
                <label for="attachments">{{ trans('cruds.leaveRequest.fields.attachments') }}</label>
                <div class="needsclick dropzone @error('attachments') is-invalid @enderror" id="attachments-dropzone">
                </div>
                @error('attachments')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <span class="help-block">{{ trans('cruds.leaveRequest.fields.attachments_helper') }}</span>
            </div>

            <div class="form-group">
                <button class="btn btn-danger" @if(empty($employee)) disabled @endif type="submit">
                    Request
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
@parent
{!! JsValidator::formRequest('App\Http\Requests\LeaveRequest\StoreLeaveRequestRequest') !!}
<script type="text/javascript">
    var uploadedAttachmentsMap = {}

    Dropzone.options.attachmentsDropzone = {
        url: '{{ route('admin.leaveRequests.storeMedia') }}',
        maxFilesize: 10, // MB
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        params: {
            size: 10
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="attachments[]" value="' + response.name + '">')
            uploadedAttachmentsMap[file.name] = response.name
        },
        removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedAttachmentsMap[file.name]
            }
            $('form').find('input[name="attachments[]"][value="' + name + '"]').remove()
        },
        init: function () {
            @if(isset($leaveRequest) && $leaveRequest->attachments)
                    var files =
                        {!! json_encode($leaveRequest->attachments) !!}
                        for (var i in files) {
                        var file = files[i]
                        this.options.addedfile.call(this, file)
                        file.previewElement.classList.add('dz-complete')
                        $('form').append('<input type="hidden" name="attachments[]" value="' + file.file_name + '">')
                        }
            @endif
        },
        error: function (file, response) {
            if ($.type(response) === 'string') {
                var message = response //dropzone sends it's own error messages in string
            } else {
                var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
            _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
            _results = []
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i]
                _results.push(node.textContent = message)
            }

            return _results
        }
    }
</script>
<script>
    $(function() {
        $('#commencement_date').datepicker({
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
            minDate: 0,
            maxDate: '+1Y+6M'
        }).on('changeDate', function (ev) {
            $('#resumption_date').datepicker('setStartDate', $("#commencement_date").val());
        });

        $('#resumption_date').datepicker({
            format: "dd-mm-yyyy",
            todayHighlight:'TRUE',
            autoclose: true,
            minDate: '0',
            maxDate: '+1Y+6M'
        })

    });
</script>
<script>
    $(function() {
        $('#upload-attach').hide();
        $('#leave_type_id').change(function() {
            let val = $(this).val();
            if(val === '3' || val === '2'){
                $('#upload-attach').show();
            }else{
                $('#upload-attach').hide();
            }
        })
    })
</script>
<script>
    $(function() {
        $('#reason1').show();
        $('#reason2').hide();
        $('#leave_type_id').change(function() {
            let val = $(this).val();
            if(val === '3'){
                $('#reason1').hide();
                $('#reason2').show();
            }else{
                $('#reason1').show();
                $('#reason2').hide();
            }
        })
    })
</script>

@endsection