<?php

namespace Database\Seeders;

use App\Models\ClientType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientType::create([
            'name' => 'PERSONA NATURAL',
            'state' => true,
        ]);
        ClientType::create([
            'name' => 'PERSONA JURIDICA',
            'state' => true,
        ]);
        ClientType::create([
            'name' => 'EMPRESA',
            'state' => true,
        ]);
    }
}
