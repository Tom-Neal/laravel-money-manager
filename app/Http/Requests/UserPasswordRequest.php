<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserPasswordRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'password' => [
                'required',
                'min:8',
                'max:32',
                'confirmed',
                'regex:/[a-z]/',    // Must include a letter
                'regex:/[0-9]/',   // Must include a digit
            ]
        ];
        return $rules;
    }

}
