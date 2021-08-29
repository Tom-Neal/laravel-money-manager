<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientTypeRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name'        => ['required', 'max:255'],
            'description' => ['nullable'],
        ];
        return $rules;
    }

}
