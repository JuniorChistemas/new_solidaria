<?php

namespace Database\Seeders;

use App\Models\TypeVoucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeVoucher::create([
            'code' => 1,
            'name' => 'FACTURA',
        ]);
        TypeVoucher::create([
            'code' => 2,
            'name' => 'TICKET',
        ]);
        TypeVoucher::create([
            'code' => 3,
            'name' => 'BOLETA',
        ]);
        TypeVoucher::create([
            'code' => 7,
            'name' => 'NOTA DE CREDITO',
        ]);
        TypeVoucher::create([
            'code' => 8,
            'name' => 'NOTA DE DEBITO',
        ]);
        TypeVoucher::create([
            'code' => 9,
            'name' => 'GUIA DE REMISION',
        ]);
        TypeVoucher::create([
            'code' => 10,
            'name' => 'ANULACION',
        ]);
    }
}
