<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (filled($row['nombre'])) {
                Product::create([
                    'name'            => $row['nombre'],
                    'composition'     => $row['composicion'] ?? null,
                    'presentation'    => $row['presentacion'] ?? null,
                    'form_farm'       => $row['forma_farmaceutica'] ?? null,
                    'barcode'         => $row['codigo_de_barras'] ?? null,
                    'laboratory_id'   => $row['laboratorio_id'],
                    'category_id'     => $row['categoria_id'],
                    'state_fraction'  => $this->normalizeYesNo($row['fraccionable']),
                    'state_igv'       => $this->normalizeYesNo($row['igv']),
                    'state'           => $this->normalizeActiveInactive($row['estado']),
                ]);
            }
        }
    }

    private function normalizeYesNo(?string $value): bool
    {
        $normalized = strtolower(trim(str_replace(['í', 'Í'], 'i', $value ?? '')));
        return $normalized === 'si';
    }

    private function normalizeActiveInactive(?string $value): bool
    {
        return strtolower(trim($value ?? '')) === 'activo';
    }
}
