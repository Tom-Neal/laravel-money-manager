<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class SettingController extends Controller
{

    public function edit(Setting $settings)
    {
        return view('settings.edit')
            ->with(compact('settings'));
    }

    public function update(Setting $settings)
    {
        $settings->update(request([
            'name', 'email', 'phone', 'bank_name', 'bank_account_number', 'bank_sort_code', 'google_map_api_key'
        ]));
        $settings->address()->update([
            'name'      => request()['address_name'],
            'address_1' => request()['address_1'],
            'address_2' => request()['address_2'],
            'address_3' => request()['address_3'],
            'postcode'  => request()['postcode'],
        ]);
        return back()->with('message', 'Settings Updated');
    }

}
