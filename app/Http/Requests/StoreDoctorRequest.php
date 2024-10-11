<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('doctor_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'nullable',
            ],
            'specialty' => [
                'string',
                'nullable',
            ],
            'crm' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'min:10',
                'max:11',
                'nullable',
            ],
        ];
    }
}
