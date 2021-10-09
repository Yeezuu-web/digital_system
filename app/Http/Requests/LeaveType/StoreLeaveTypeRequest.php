<?php

namespace App\Http\Requests\LeaveType;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_type_create');
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
