<?php

namespace App\Http\Requests\LineManager;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLineManagerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('line_manager_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:line_managers,id',
        ];
    }
}
