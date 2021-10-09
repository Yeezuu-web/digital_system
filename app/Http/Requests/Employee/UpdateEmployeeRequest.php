<?php

namespace App\Http\Requests\Employee;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('employee_edit');
    }

   
    public function rules()
    {
        return [
            'empId' => [
                'string',
                'required',
                'min:5'
            ],
            'first_name' => [
                'string',
                'required',
                'min:3'
            ],
            'last_name' => [
                'string',
                'required',
                'min:3'
            ],
            'gender' => [
                'string',
                'required'
            ],
            'eligible_leave' => [
                'string',
                'required'
            ],
            'hire_date' => [
                'date',
                'required'
            ],
            'position_id' => [
                'required'
            ],
            'user_id' => [
                'required'
            ],
        ];
    }
}
