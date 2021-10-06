<?php

namespace Tests\Feature;

use App\Models\{Invoice, User};
use Database\Seeders\{
    ClientTypeTableSeeder,
    InvoiceStatusTableSeeder,
    SettingTableSeeder,
    UserTableSeeder
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class InvoiceCopyTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_invoice_copy_view()
    {
        $invoice = Invoice::factory()->create();
        $response = $this->get('/invoices/copy/'.$invoice->id);
        $response->assertOk();
    }

    public function test_invoice_copy_store()
    {
        $invoice = Invoice::factory()->create();
        $this->assertDatabaseCount('invoices', 1);
        $response = $this->post('/invoices/copy/'.$invoice->id);
        $response->assertRedirect();
        $this->assertDatabaseCount('invoices', 2);
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
