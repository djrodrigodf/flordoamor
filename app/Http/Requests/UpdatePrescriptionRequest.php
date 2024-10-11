<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePrescriptionRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('prescription_edit');
    }

    public function rules()
    {
        return [];
    }
}
