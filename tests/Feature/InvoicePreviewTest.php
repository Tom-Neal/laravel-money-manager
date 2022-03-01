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

class InvoicePreviewTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_invoice_preview()
    {
        $text = "Test Text";
        $clientDescription = "<div><div>{$text}</div><div>Street Name</div><div>Postcode</div></div>";
        $invoice = Invoice::factory()->create([
            'client_description' => $clientDescription
        ]);
        $this->assertDatabaseHas('invoices', [
            'client_description' => $clientDescription
        ]);
        $response = $this->get('/invoices/download/preview/'.$invoice->id);
        $response->assertOk();
        $response->assertSeeText($text);
        $response->assertDontSee($invoice->client->name);
        $invoice->update([
            'client_description' => NULL
        ]);
        $response = $this->get('/invoices/download/preview/'.$invoice->id);
        $response->assertDontSee($text);
        $response->assertSeeText($invoice->client->name);
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
