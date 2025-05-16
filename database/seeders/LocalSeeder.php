<?php

namespace Database\Seeders;

use App\Models\Local;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Local::create([
            'name' => 'ALMACEN',
            'address' => 'PIURA',
            'series' => 'S0001',
            'series_note' => 'SN0001',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'DISTRIBUCION',
            'address' => 'PIURA',
            'series' => 'S0002',
            'series_note' => 'SN0002',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'VENCIDOS',
            'address' => 'PIURA',
            'series' => 'S0003',
            'series_note' => 'SN0003',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'PIURA_CASTILLA',
            'address' => 'PIURA',
            'series' => 'S0004',
            'series_note' => 'SN0004',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'SULLANA_NUEVO',
            'address' => 'PIURA',
            'series' => 'S0005',
            'series_note' => 'SN0005',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'SULLANA_VIEJO',
            'address' => 'PIURA',
            'series' => 'S0006',
            'series_note' => 'SN0006',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'TALARA',
            'address' => 'PIURA',
            'series' => 'S0007',
            'series_note' => 'SN0007',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'TUMBES',
            'address' => 'TUMBES',
            'series' => 'S0008',
            'series_note' => 'SN0008',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'TRUJILLO',
            'address' => 'LA LIBERTAD',
            'series' => 'S0009',
            'series_note' => 'SN0009',
            'status' => 1,
        ]);
        Local::create([
            'name' => 'LIMA',
            'address' => 'LIMA',
            'series' => 'S0010',
            'series_note' => 'SN0010',
            'status' => 1,
        ]);
    }
}
