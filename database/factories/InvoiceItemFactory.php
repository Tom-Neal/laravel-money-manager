<?php

namespace Database\Factories;

use App\Models\{InvoiceItem, Invoice};
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoiceItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'description'      => $this->faker->text,
            'price'            => rand(1000, 100000),
            'hours'            => rand(1, 16),
            'renewal_required' => $this->faker->date,
            'invoice_id'       => Invoice::factory()
        ];
    }

}
