<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{

    public function run()
    {

        Setting::create([
            'name'               => '',
            'email'              => '',
            'phone'              => '',
            'google_map_api_key' => ''
        ]);

    }

}
