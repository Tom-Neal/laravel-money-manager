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
            'name', 'email', 'phone', 'google_map_api_key'
        ]));
        return back()->with('message', 'Settings Updated');
    }

}
