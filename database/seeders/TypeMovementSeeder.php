<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TypeMovement;

class TypeMovementSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['name' => 'Factura', 'serie' => 'F001', 'correlativo' => 0],
            ['name' => 'Guía', 'serie' => 'G001', 'correlativo' => 0],
            ['name' => 'Boleta', 'serie' => 'B001', 'correlativo' => 0],
            ['name' => 'Venta', 'serie' => 'V001', 'correlativo' => 0],
        ];
        
        foreach ($tipos as $tipo) {
            TypeMovement::create($tipo);
        }
    }
}