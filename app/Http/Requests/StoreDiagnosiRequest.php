<?php

namespace App\Http\Requests;

use App\Models\Diagnosi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
