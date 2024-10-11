<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('prescription_create');
    }

    public function rules()
    {
        return [];
    }
}
