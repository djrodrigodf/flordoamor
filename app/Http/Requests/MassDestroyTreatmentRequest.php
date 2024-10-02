<?php

namespace App\Http\Requests;

use App\Models\Treatment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyTreatmentRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('treatment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:treatments,id',
        ];
    }
}
