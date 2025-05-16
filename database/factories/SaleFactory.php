<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement([1, 7]),
            'customer_id' => CustomerFactory::new()->create()->id,
            'local_id' => $this->faker->numberBetween(1, 10),
            'doctor_id' => $this->faker->randomElement([1, 20]),
            'type_voucher_id' => $this->faker->randomElement([1, 3]),
            'type_payment_id' => $this->faker->randomElement([1, 5]),
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'code_card' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'op_gravada' => $this->faker->randomFloat(2, 0, 1000),
            'op_exonerada' => $this->faker->randomFloat(2, 0, 1000),
            'op_inafecta' => $this->faker->randomFloat(2, 0, 1000),
            'igv' => $this->faker->randomFloat(2, 0, 1000),
            'total' => $this->faker->randomFloat(2, 0, 1000),
            'status_sale' => $this->faker->boolean(),
            'state_sunat' => $this->faker->boolean(),
        ];
    }
}
