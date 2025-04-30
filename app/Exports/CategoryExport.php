<?php

namespace App\Exports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class CategoryExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return Category::orderBy('id', 'asc')->get();
    }

    public function map($category): array
    {
        return [
            $category->id,
            $category->name,
            $category->status == 1 ? 'Activo' : 'Inactivo'
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
        return 'B5'; // Mismo patrón que en Laboratory
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('B3:D3');
        $sheet->setCellValue('B3', 'Lista de categorías de Solidaria');

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

                $sheet->setAutoFilter('B5:D5');

                foreach (range('B', 'D') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                for ($row = 6; $row <= $highestRow; $row++) {
                    $estado = $sheet->getCell('D' . $row)->getValue();

                    if (strtolower(trim($estado)) === 'inactivo') {
                        $sheet->getStyle('B' . $row . ':D' . $row)->applyFromArray([
                            'fill' => [
                                'fillType' => 'solid',
                                'startColor' => ['rgb' => 'D9D9D9'],
                            ],
                        ]);

                        $sheet->getStyle('D' . $row)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => 'FF0000'],
                                'bold' => true,
                            ],
                        ]);
                    } elseif (strtolower(trim($estado)) === 'activo') {
                        $sheet->getStyle('D' . $row)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '00B050'],
                                'bold' => true,
                            ],
                        ]);
                    }
                }

                $sheet->getSheetView()->setZoomScale(120);
            },
        ];
    }
}
