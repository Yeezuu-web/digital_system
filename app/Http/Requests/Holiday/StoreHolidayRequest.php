<?php

namespace App\Http\Requests\Holiday;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreHolidayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('holiday_create');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3'
            ],
            'dates' => [
                'required',
                'array'
            ],
            'year' => [
                'required',
                'string',
                'min:4'
            ]
        ];
    }
}
