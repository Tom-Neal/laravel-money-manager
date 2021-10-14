<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name'                  => ['required', 'max:255'],
            'email'                 => ['required', 'max:255'],
            'phone'                 => ['nullable', 'max:255'],
            'bank_name'             => ['nullable', 'max:255'],
            'bank_account_number'   => ['nullable', 'max:255'],
            'bank_sort_code'        => ['nullable', 'max:255'],
            'google_map_api_key'    => ['nullable', 'max:255'],
            'address_name'          => ['nullable', 'max:255'],
            'address_1'             => ['nullable', 'max:255'],
            'address_2'             => ['nullable', 'max:255'],
            'address_3'             => ['nullable', 'max:255'],
            'postcode'              => ['nullable', 'max:255'],
        ];
        return $rules;
    }

}
