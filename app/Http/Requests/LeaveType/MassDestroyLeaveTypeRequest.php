<?php

namespace App\Http\Requests\LeaveType;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyLeaveTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('leave_manager_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:leave_types,id',
        ];
    }
}
