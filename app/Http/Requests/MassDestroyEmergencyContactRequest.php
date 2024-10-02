<?php

namespace App\Http\Requests;

use App\Models\EmergencyContact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyEmergencyContactRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('emergency_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:emergency_contacts,id',
        ];
    }
}
