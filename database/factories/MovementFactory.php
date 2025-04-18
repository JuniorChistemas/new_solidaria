<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MovementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->regexify('[A-Z0-9]{10}'),
            'fechaEmision' => $this->faker->date(),
            'fechaEjecucion' => $this->faker->date(),
            'fechaCredito' => $this->faker->optional()->date(),
            'idProveedor' => 1,
            'idUser' => 1,
            'idTipoMovimiento' => $this->faker->numberBetween(1, 4),
            'estado' => 1,
            'estadoIgv' => $this->faker->randomElement([1, 2]),
            'tipoPago' => $this->faker->randomElement(['contado']),
        ];
    }
}
