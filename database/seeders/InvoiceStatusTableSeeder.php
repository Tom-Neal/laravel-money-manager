<?php

namespace Database\Seeders;

use App\Models\ClientType;
use App\Models\InvoiceStatus;
use Illuminate\Database\Seeder;

class InvoiceStatusTableSeeder extends Seeder
{

    public function run()
    {

        InvoiceStatus::create([
            'name'   => 'Created',
            'colour' => 'danger'
        ]);

        InvoiceStatus::create([
            'name'   => 'Sent',
            'colour' => 'info'
        ]);

        InvoiceStatus::create([
            'name'   => 'Part Paid',
            'colour' => 'warning'
        ]);

        InvoiceStatus::create([
            'name'   => 'Paid',
            'colour' => 'success'
        ]);

        InvoiceStatus::create([
            'name'   => 'Refunded',
            'colour' => 'secondary'
        ]);

    }

}
