<?php

namespace Tests\Feature;

use App\Http\Livewire\ExpensePage;
use App\Models\Expense;
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

class ExpenseTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_expenses_index_view()
    {
        $response = $this->get('/expenses');
        $response->assertSeeLivewire(ExpensePage::class);
    }

//    public function test_delete_expense() {
//        $expense = Expense::factory()->create();
//
//    }

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
