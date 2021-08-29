<?php

namespace Database\Factories;

use App\Models\ClientType;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientTypeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'icon' => 'fa-user',
        ];
    }

}
