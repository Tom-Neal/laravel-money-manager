<?php

namespace Tests\Feature;

use App\Http\Livewire\{InvoicePage, InvoiceTableRowComponent};
use App\Models\{Business, Invoice, User};
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
        $response->assertSeeLivewire(InvoiceTableRowComponent::class);
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

        $number = 1234;
        Livewire::test(InvoicePage::class, [
            'invoice' => $invoice
        ])
            ->set('invoice.number', $number)
            ->call('update', 'number');
        $this->assertDatabaseHas('invoices', [
           'number' => $number
        ]);

        $business = Business::factory()->create();
        Livewire::test(InvoicePage::class, [
            'invoice' => $invoice
        ])
            ->set('invoice.business_id', $business->id)
            ->call('update', 'business_id');
        $this->assertDatabaseHas('invoices', [
            'business_id' => $business->id
        ]);

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
