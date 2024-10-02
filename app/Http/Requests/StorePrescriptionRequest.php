<?php

namespace App\Http\Requests;

use App\Models\Prescription;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
