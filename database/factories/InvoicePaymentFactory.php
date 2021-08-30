<?php

namespace Database\Factories;

use App\Models\{InvoicePayment, Invoice};
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoicePaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = InvoicePayment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'total'      => rand(1000, 20000),
            'date_paid'  => $this->faker->date,
            'invoice_id' => Invoice::factory()
        ];
    }

}
