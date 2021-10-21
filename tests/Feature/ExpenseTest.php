<?php

namespace Tests\Feature;

use App\Models\Expense;
use App\Http\Livewire\{ExpensePage, ExpenseTableRowComponent};
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
        $response->assertSeeLivewire(ExpenseTableRowComponent::class);
    }

    public function test_store_expense()
    {
        $description = $this->faker->text;
        Livewire::test(ExpensePage::class,)
            ->set('description', $description)
            ->set('category', Expense::CATEGORY_CHARGE)
            ->set('price', 100)
            ->set('date_incurred', '2021-10-08')
            ->set('vat_included', rand(0, 1))
            ->call('store');
        $this->assertDatabaseCount('expenses', 1);
        $this->assertDatabaseHas('expenses', [
            'description'   => $description,
            'category'      => Expense::CATEGORY_CHARGE,
            'date_incurred' => '2021-10-08'
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
