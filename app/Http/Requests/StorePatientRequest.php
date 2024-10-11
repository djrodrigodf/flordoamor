<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('patient_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'nullable',
            ],
            'email' => [
                'required',
                'unique:patients',
            ],
            'phone' => [
                'string',
                'min:10',
                'max:11',
                'nullable',
            ],
            'birth_date' => [
                'date_format:'.config('panel.date_format'),
                'nullable',
            ],
            'rg' => [
                'string',
                'nullable',
            ],
            'cpf' => [
                'string',
                'required',
                'unique:patients',
            ],
            'address' => [
                'string',
                'nullable',
            ],
            'number' => [
                'string',
                'nullable',
            ],
            'complement' => [
                'string',
                'nullable',
            ],
            'neighborhood' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'postal_code' => [
                'string',
                'nullable',
            ],
        ];
    }
}
