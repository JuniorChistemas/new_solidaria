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
        $batch = [];

        foreach ($rows as $row) {
            if (filled($row['nombre'])) {
                $batch[] = [
                    'name'            => $row['nombre'],
                    'composition'     => $row['composicion'] ?? null,
                    'presentation'    => $row['presentacion'] ?? null,
                    'form_farm'       => $row['forma_farmaceutica'] ?? null,
                    'barcode'         => $row['codigo_barras'] ?? null,
                    'laboratory_id'   => $row['laboratorio_id'],
                    'category_id'     => $row['categoria_id'],
                    'state_fraction'  => $this->normalizeYesNo($row['fraccionable']),
                    'state_igv'       => $this->normalizeYesNo($row['igv']),
                    'state'           => $this->normalizeActiveInactive($row['estado']),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ];

                // Cuando el batch llega a 500, lo insertamos y limpiamos
                if (count($batch) === 500) {
                    Product::insert($batch);
                    $batch = [];
                }
            }
        }

        // Insertamos el resto (si quedó algo)
        if (!empty($batch)) {
            Product::insert($batch);
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
