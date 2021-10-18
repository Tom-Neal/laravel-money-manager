<?php

namespace Tests\Feature;

use App\Http\Livewire\CommentIndexPage;
use App\Models\Comment;
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

class CommentTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_comment_index_view()
    {
        $response = $this->get('/comments');
        $response->assertOk();
        $response->assertSeeLivewire(CommentIndexPage::class);
    }

    public function test_store_comment()
    {
        Livewire::test(CommentIndexPage::class, [
            'description' => $this->faker->text
        ])
            ->call('store')
            ->assertDispatchedBrowserEvent('notify');
        $this->assertDatabaseCount('comments', 1);
    }

    public function test_destroy_comment()
    {
        Livewire::test(CommentIndexPage::class, [
            'description' => $this->faker->text
        ])
            ->call('store');
        $comment = Comment::first();
        Livewire::test(CommentIndexPage::class)
            ->call('destroy', $comment->id)
            ->assertDispatchedBrowserEvent('notify');
        $this->assertDatabaseCount('comments', 0);
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
