<?php

namespace App\Http\Requests;

use App\Models\Doctor;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
