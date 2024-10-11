<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiagnosiRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('diagnosi_edit');
    }

    public function rules()
    {
        return [];
    }
}
