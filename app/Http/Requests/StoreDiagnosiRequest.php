<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreDiagnosiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('diagnosi_create');
    }

    public function rules()
    {
        return [];
    }
}
