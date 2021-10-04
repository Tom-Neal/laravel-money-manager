<?php

namespace Tests\Feature;

use App\Models\ClientType;
use App\Models\User;
use Database\Seeders\{
    ClientTypeTableSeeder,
    SettingTableSeeder,
    UserTableSeeder
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\{RefreshDatabase, WithFaker};

class ClientTypeTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    protected $baseUrl = 'http://localhost';

    protected function setUp(): void
    {
        parent::setUp();
        $this->seedDatabase();
        $this->actingAsAdmin();
    }

    public function test_client_type_index_view()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/client-types');
        $response->assertOk();
    }

    public function test_client_type_create_view()
    {
        $response = $this->get('/client-types/create');
        $response->assertOk();
    }

    public function test_client_type_show_view()
    {
        $clientType = ClientType::factory()->create();
        $response = $this->get('/client-types/show/' . $clientType->id);
        $response->assertOk();
    }

    public function test_client_type_edit_view()
    {
        $clientType = ClientType::factory()->create();
        $response = $this->get('/client-types/edit/' . $clientType->id);
        $response->assertOk();
    }

    public function test_update_client_type()
    {
        $clientType = ClientType::factory()->create();
        $attributes = [
            'name'        => $this->faker->name,
            'description' => $this->faker->text,
        ];
        $this->assertDatabaseHas('client_types', ['name' => $clientType->name, 'description' => $clientType->description]);
        $this->patch('/client-types/' . $clientType->id, $attributes);
        $this->assertDatabaseHas('client_types', $attributes);
    }

    public function test_delete_client_type()
    {
        $clientType = ClientType::factory()->create();
        $this->delete('/client-types/' . $clientType->id);
        $this->assertDatabaseMissing('client_types', ['name' => $clientType->name]);
    }

    private function seedDatabase()
    {
        $this->seed(SettingTableSeeder::class);
        $this->seed(UserTableSeeder::class);
        $this->seed(ClientTypeTableSeeder::class);
    }

    private function actingAsAdmin()
    {
        $this->be(User::first());
    }

}
