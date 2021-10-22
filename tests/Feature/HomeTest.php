<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\{
    ClientTypeTableSeeder,
    InvoiceStatusTableSeeder,
    SettingTableSeeder,
    UserTableSeeder
};
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class HomeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_home_view()
    {
        $response = $this->get('/home');
        $response->assertOk();
        $response->assertViewHas('invoiceYears');
        $response->assertViewHas('expenseYears');
        $response->assertViewHas('recentInvoices');
        $response->assertViewHas('invoiceItemsRenewalRequired');
        Cache::shouldReceive('invoiceYearsCache');
        Cache::shouldReceive('expenseYearsCache');
        Cache::shouldReceive('renewalRequiredSoonCache');
        Cache::shouldReceive('recentInvoicesCache');
    }

    private function seedDatabase()
    {
        $this->seed(SettingTableSeeder::class);
        $this->seed(UserTableSeeder::class);
        $this->seed(ClientTypeTableSeeder::class);
        $this->seed(InvoiceStatusTableSeeder::class);
    }

    private function actingAsAdmin()
    {
        $this->be(User::first());
    }

}
