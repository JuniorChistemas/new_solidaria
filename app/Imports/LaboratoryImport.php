<?php

namespace App\Imports;

use App\Models\Laboratory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LaboratoryImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $row){
            Laboratory::create([
                'name' => $row['nombre'],
                'state' => strtolower($row['estado']) === 'activo' ? true : false,
            ]);
        }
    }
}
