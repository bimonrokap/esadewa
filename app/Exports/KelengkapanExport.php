<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KelengkapanExport implements FromCollection, ShouldAutoSize, WithEvents
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

                $sheet->mergeCells('B1:B2');
                $sheet->mergeCells('C1:C2');
                $sheet->mergeCells('G1:G2');
                $sheet->mergeCells('D1:F1');
                $sheet->mergeCells('B'.$endRow.':C'.$endRow);

                $sheet->getStyle("B1:G2")->applyFromArray([
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

                $sheet->getStyle("B1:G$endRow")->applyFromArray([
                    'borders' => [
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_THICK
                        ]
                    ]
                ]);
            },
        ];
    }
}
