<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\{SettingTableSeeder, UserTableSeeder};
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class SettingTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_get_setting_view()
    {
        $response = $this->get('/settings/edit/1');
        $response->assertOk();
    }

    public function test_update_setting()
    {
        $attributes = [
            'name'              => $this->faker->name(),
            'email'             => $this->faker->unique()->safeEmail,
            'phone'             => $this->faker->phoneNumber(),
            'bank_name'         => 'Monzo',
            'address_name'      => $this->faker->streetName,
            'postcode'          => $this->faker->postcode,
        ];
        $response = $this->patch('/settings/1', $attributes);
        $response->assertStatus(302);
        $this->assertDatabaseHas('settings', [
            'email'     => $attributes['email'],
            'bank_name' => $attributes['bank_name'],
        ]);
        $this->assertDatabaseHas('addresses', [
            'name'          => $attributes['address_name'],
            'postcode'      => $attributes['postcode'],
        ]);
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
