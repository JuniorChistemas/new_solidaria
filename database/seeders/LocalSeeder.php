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
    }
}
