<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreEmergencyContactRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('emergency_contact_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'nullable',
            ],
            'relationship' => [
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
