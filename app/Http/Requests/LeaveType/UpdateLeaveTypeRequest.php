<?php

namespace App\Http\Requests\LeaveType;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_type_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
            ],
            'default_dur' => [
                'required',
            ],
        ];
    }
}
