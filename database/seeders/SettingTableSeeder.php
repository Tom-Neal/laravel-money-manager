<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{

    public function run()
    {

        $settings = Setting::create([
            'name'               => '',
            'email'              => '',
            'phone'              => '',
            'google_map_api_key' => ''
        ]);
        $settings->address()->create([
            'name'      => 'Address name',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'postcode'  => 'Postcode',
        ]);

    }

}
