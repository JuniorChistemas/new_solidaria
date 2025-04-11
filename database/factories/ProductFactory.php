<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => substr($this->faker->name, 0, 50), 
            'composition'  => substr($this->faker->text, 0, 10),
            'presentation'  => substr($this->faker->text, 0, 10),
            'form_farm'  => substr($this->faker->text, 0, 10),
            'barcode'  => $this->faker->numerify('8#######'),
            'laboratory_id' => $this->faker->numberBetween(1, 5),
            'category_id' => $this->faker->numberBetween(1, 50),
            'state_fraction'    => $this->faker->boolean(),
            'state_igv'    => $this->faker->boolean(),
            'state'    => $this->faker->boolean(),
        ];
    }
}
