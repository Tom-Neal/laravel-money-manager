<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Seeder;

class ClientTypeTableSeeder extends Seeder
{

    public function run()
    {

        ClientType::create([
            'name' => 'Test CT',
            'slug' => 'test-ct',
            'icon' => 'fa-code'
        ]);

    }

}
