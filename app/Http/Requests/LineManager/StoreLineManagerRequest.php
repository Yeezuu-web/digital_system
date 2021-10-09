<?php

namespace App\Http\Requests\LineManager;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreLineManagerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('line_manager_create');
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
