<?php

namespace App\Http\Requests\LeaveRequest;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreLeaveRequestRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_request_create');
    }

    public function rules()
    {
        return [
            'commencement_date' => [
                'required',
                'date'
            ],
            'resumption_date' => [
                'required',
                'date'
            ],
            'no_of_day' => [
                'required',
                'integer'
            ],
            'reason' => [
                'string'
            ],
            'employee_id' => [
                'integer'
            ],
            'leave_type_id' => [
                'required'
            ],
            'status' => [
                'nullable',
            ],
            'attachments.*' => [
                'required',
            ],
        ];
    }
}
