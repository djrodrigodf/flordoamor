<?php

namespace App\Http\Requests;

use App\Models\Diagnosi;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

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
