<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

    public function run()
    {

        User::create([
            'first_name' => 'Tom',
            'last_name'  => 'Neal',
            'email'      => 'hello@tomneal.co.uk',
            'password'   => bcrypt('password')
        ]);

    }

}
