<?php

namespace App\Http\Requests;

use App\Models\Diagnosi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDiagnosiRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('diagnosi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:diagnosis,id',
        ];
    }
}
