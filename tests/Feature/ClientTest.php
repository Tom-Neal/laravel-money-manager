<?php

namespace Tests\Feature;

use App\Http\Livewire\{ClientShowPage, ClientEditPage};
use App\Models\{Client, InvoiceStatus, User};
use Database\Seeders\{
    ClientTypeTableSeeder,
    InvoiceStatusTableSeeder,
    SettingTableSeeder,
    UserTableSeeder
};
use Livewire\Livewire;
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class ClientTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_client_show_view()
    {
        $client = Client::factory()->create();
        $this->assertDatabaseCount('clients', 1);
        $response = $this->get('/clients/show/' . $client->id);
        $response->assertOk();
        $response->assertSeeLivewire(ClientShowPage::class);
    }

    public function test_client_edit_view()
    {
        $client = Client::factory()->create();
        $response = $this->get('/clients/edit/' . $client->id);
        $response->assertOk();
        $response->assertSeeLivewire(ClientEditPage::class);
    }

    public function test_client_store_invoice()
    {
        $client = Client::factory()->create();
        Livewire::test(ClientShowPage::class, [
            'client' => $client
        ])
            ->call('storeInvoice', [
                'total'             => rand(0, 100000),
                'date_sent'         => '2021-10-01',
                'invoice_status_id' => InvoiceStatus::CREATED,
            ]);
        $this->assertDatabaseCount('invoices', 1);
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
