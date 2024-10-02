<?php

namespace App\Http\Requests;

use App\Models\Treatment;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTreatmentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('treatment_create');
    }

    public function rules()
    {
        return [
            'start_date' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
        ];
    }
}
