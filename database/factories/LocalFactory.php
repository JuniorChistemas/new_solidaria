<?php

namespace Database\Factories;

use App\Models\Local;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocalFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Local::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'         => $this->faker->company,
            'address'      => $this->faker->address,
            'series'       => strtoupper($this->faker->bothify('??##')),
            'series_note'  => $this->faker->optional()->sentence,
            'status' => $this->faker->randomElement(['0', '1']),
        ];
    }
}
