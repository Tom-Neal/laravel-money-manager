<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\{SettingTableSeeder, UserTableSeeder};
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class UserProfileTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_user_profile_view()
    {
        $response = $this->get('/users/profile');
        $response->assertOk();
    }

    public function test_update_user_profile()
    {
        $attributes = [
            'email'                 => $this->faker->unique()->safeEmail,
            'password'              => 'newPassword99',
            'password_confirmation' => 'newPassword99',
        ];
        $response = $this->patch('/users/profile', $attributes);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => $attributes['email']]);
    }

    private function seedDatabase()
    {
        $this->seed(SettingTableSeeder::class);
        $this->seed(UserTableSeeder::class);
    }

    private function actingAsAdmin()
    {
        $this->be(User::first());
    }
}
