<?php

namespace Tests\Feature;

use App\Http\Livewire\StatementPage;
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

class StatementTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_statement_view()
    {
        $response = $this->get('/statements');
        $response->assertOk();
        $response->assertSeeLivewire(StatementPage::class);
    }

    public function test_get_statement_data()
    {
        Livewire::test(StatementPage::class)
            ->call('getData')
            ->assertSet('showData', true)
            ->assertDispatchedBrowserEvent('notify');
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
