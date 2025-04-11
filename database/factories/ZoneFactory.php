<?php

namespace Database\Factories;

use App\Models\Zone;
use Illuminate\Database\Eloquent\Factories\Factory;

class ZoneFactory extends Factory
{
    protected $model = Zone::class;

    public function definition(): array
    {
        $zoneNames = [
            'Zona Norte',
            'Zona Sur',
            'Zona Este',
            'Zona Oeste',
            'Zona Central',
            'Zona Industrial',
            'Zona Comercial',
            'Zona Administrativa'
        ];

        return [
            'name' => $this->faker->randomElement($zoneNames),
            'status' => $this->faker->randomElement(['0', '1']),
        ];
    }
}
