<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('document_create');
    }

    public function rules()
    {
        return [];
    }
}
