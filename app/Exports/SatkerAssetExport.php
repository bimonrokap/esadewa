<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SatkerAssetExport implements FromCollection, ShouldAutoSize, WithEvents
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $endRow = $sheet->getHighestRow();
                $endCol = $sheet->getHighestColumn();

                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $step = 4;
                $column = 'D';
                for ($i = 0;$i<14;$i++) {
                    $columnNumber = Coordinate::columnIndexFromString($column) + $step;
                    $newColumn = Coordinate::stringFromColumnIndex($columnNumber - 1);
                    $sheet->mergeCells($column . '1:'.$newColumn.'1');
                    $column = Coordinate::stringFromColumnIndex($columnNumber);
                }
                $sheet->mergeCells('B'.$endRow.':C'.$endRow);
//
                $sheet->getStyle("B1:".$endCol.'2')->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                $sheet->getStyle("B$endRow")->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    )
                ]);

                $sheet->getStyle("B1:".$endCol.$endRow)->applyFromArray([
                    'borders' => [
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_MEDIUM
                        ]
                    ]
                ]);
            },
        ];
    }
}
