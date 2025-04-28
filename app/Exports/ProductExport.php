<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithCustomStartCell, WithEvents
{
    public function collection()
    {
        return Product::with(['laboratory', 'category'])->orderBy('id', 'asc')->get();
    }

    public function map($product): array
    {
        return [
            $product->id,
            $product->name,
            $product->composition ?? '-',
            $product->presentation ?? '-',
            $product->form_farm ?? '-',
            $product->barcode ?? '-',
            $product->laboratory?->name ?? 'Sin laboratorio',
            $product->category?->name ?? 'Sin categoría',
            $product->state_fraction ? 'Sí' : 'No',
            $product->state_igv ? 'Sí' : 'No',
            $product->state ? 'Activo' : 'Inactivo',
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Composición',
            'Presentación',
            'Forma farmacéutica',
            'Código de barras',
            'Laboratorio',
            'Categoría',
            'Fraccionable',
            'Afecto IGV',
            'Estado',
        ];
    }

    public function startCell(): string
    {
        return 'B4'; // El encabezado empieza en B4
    }

    public function styles(Worksheet $sheet)
    {
        // Título
        $sheet->mergeCells('B2:L2');
        $sheet->setCellValue('B2', 'Lista de productos de Solidaria');

        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        // Estilos de encabezados
        $sheet->getStyle('B4:L4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin'],
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

                // Ajustar altura de la fila 1 (margen superior)
                $sheet->getRowDimension(1)->setRowHeight(10);

                // Ajustar ancho de la columna A (margen izquierdo)
                $sheet->getColumnDimension('A')->setWidth(2);

                // Bordes y alineación para todo el contenido
                $sheet->getStyle('B5:L' . $highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => 'thin'],
                    ],
                ]);

                // Filtros en los encabezados
                $sheet->setAutoFilter('B4:L4');

                // Autoancho dinámico de columnas
                foreach (range('B', 'L') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                // Aplicar color al Estado según valor
                for ($row = 5; $row <= $highestRow; $row++) {
                    $estado = $sheet->getCell('L' . $row)->getValue();
                
                    if (strtolower(trim($estado)) === 'activo') {
                        $sheet->getStyle('L' . $row)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => '00B050'], // Verde
                                'bold' => true,
                            ],
                        ]);
                    } elseif (strtolower(trim($estado)) === 'inactivo') {
                        $sheet->getStyle('B' . $row . ':L' . $row)->applyFromArray([
                            'fill' => [
                                'fillType' => 'solid',
                                'startColor' => ['rgb' => 'D9D9D9'], // Fondo gris claro
                            ],
                        ]);
                
                        $sheet->getStyle('L' . $row)->applyFromArray([
                            'font' => [
                                'color' => ['rgb' => 'FF0000'], // Rojo
                                'bold' => true,
                            ],
                        ]);
                    }
                }
                

                // Zoom 100%
                $sheet->getSheetView()->setZoomScale(100);
            },
        ];
    }
}
