<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeMovement;

class TypeMovementSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = ['Factura', 'Guía', 'Boleta', 'Venta'];

        foreach ($tipos as $tipo) {
            TypeMovement::create(['nombre' => $tipo]);
        }
    }
}
