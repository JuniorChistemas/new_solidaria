<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $locales = [1, 2, 3];

        $origin = $this->faker->randomElement($locales);
        // Filtramos para que el destino no sea igual al origen
        $destination = $this->faker->randomElement(array_filter($locales, fn($id) => $id !== $origin));

        return [
            'origin_local_id' => $origin,
            'destination_local_id' => $destination,
            'type_movement_id' => $this->faker->numberBetween(1, 4),
            'code' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'status' => $this->faker->randomElement(['pending', 'completed', 'in_progress', 'canceled']),
            'sent_at' => $this->faker->dateTime(),
        ];
    }
}
