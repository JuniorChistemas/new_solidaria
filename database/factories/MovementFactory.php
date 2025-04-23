<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'issue_date' => $this->faker->date(),
            'credit_date' => $this->faker->optional()->date(),
            'supplier_id' => 1,
            'user_id' => 1,
            'type_movement_id' => $this->faker->numberBetween(1, 4),
            'status' => 1,
            'igv_status' => $this->faker->randomElement([1, 2]),
            'payment_type' => $this->faker->randomElement(['contado']),
        ];
    }
}
