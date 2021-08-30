<?php

namespace Tests\Feature;

use App\Http\Livewire\InvoicePage;
use App\Models\Invoice;
use App\Models\User;
use Database\Seeders\{
    ClientTypeTableSeeder,
    InvoiceStatusTableSeeder,
    SettingTableSeeder,
    UserTableSeeder
};
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class InvoiceTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_invoice_index_view()
    {
        $response = $this->get('/invoices');
        $response->assertOk();
    }

    public function test_get_invoice_edit_view()
    {
        $invoice = Invoice::factory()->create();
        $response = $this->get('/invoices/edit/' . $invoice->id);
        $response->assertOk();
        $response->assertSeeLivewire(InvoicePage::class);
    }

    public function test_update_invoice()
    {
        $invoice = Invoice::factory()->create();
        Livewire::test(InvoicePage::class, [
            'invoice' => $invoice
        ])
            ->call('update', 'number');
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
