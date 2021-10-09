<?php

namespace App\Http\Requests\LineManager;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLineManagerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('line_manager_edit');
    }

    public function rules()
    {
        return [
            'employee_id' => [
                'required',
            ],
            'department_id' => [
                'required',
            ],
        ];
    }
}
