<?php

namespace App\Http\Requests;

use App\Models\Prescription;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
