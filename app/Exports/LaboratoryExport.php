<?php

namespace App\Exports;

use App\Models\Laboratory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class LaboratoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return Laboratory::orderBy('id', 'asc')->get();
    }

    public function map($laboratory): array
    {
        return [
            $laboratory->id,
            $laboratory->name,
            $laboratory->state == 1 ? 'Activo' : 'Inactivo'
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Estado'
        ];
    }

    public function startCell(): string
    {
        return 'B5'; // Ahora empieza en B5
    }

    public function styles(Worksheet $sheet)
    {
        // Título general
        $sheet->mergeCells('B3:D3'); // Título desde B3 hasta D3
        $sheet->setCellValue('B3', 'Lista de laboratorios de Solidaria');

        $sheet->getStyle('B3')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '4F81BD',
                ],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Encabezados
        $sheet->getStyle('B5:D5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => '4F81BD',
                ],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
{
    return [
        AfterSheet::class => function(AfterSheet $event) {
            $sheet = $event->sheet->getDelegate();
            
            $highestRow = $sheet->getHighestRow();

            // Bordes y alineación
            $sheet->getStyle('B6:D' . $highestRow)->applyFromArray([
                'alignment' => [
                    'horizontal' => 'center',
                    'vertical' => 'center',
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                    ],
                ],
            ]);

            // Autofiltro
            $sheet->setAutoFilter('B5:D5');

            // Ajustar ancho automático
            foreach (range('B', 'D') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Recorrer las filas para aplicar colores y fondos
            for ($row = 6; $row <= $highestRow; $row++) {
                $estado = $sheet->getCell('D' . $row)->getValue();

                if (strtolower(trim($estado)) === 'inactivo') {
                    // Fondo gris en toda la fila (ID, Nombre, Estado)
                    $sheet->getStyle('B' . $row . ':D' . $row)->applyFromArray([
                        'fill' => [
                            'fillType' => 'solid',
                            'startColor' => ['rgb' => 'D9D9D9'], // Gris claro
                        ],
                    ]);

                    // Texto rojo en Estado
                    $sheet->getStyle('D' . $row)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => 'FF0000'], // Rojo
                            'bold' => true,
                        ],
                    ]);
                } elseif (strtolower(trim($estado)) === 'activo') {
                    // Solo texto verde en Estado
                    $sheet->getStyle('D' . $row)->applyFromArray([
                        'font' => [
                            'color' => ['rgb' => '00B050'], // Verde
                            'bold' => true,
                        ],
                    ]);
                }
            }

            // Zoom automático
            $sheet->getSheetView()->setZoomScale(120);
        },
    ];
}

}
