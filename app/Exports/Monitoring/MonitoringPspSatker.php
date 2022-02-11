<?php

namespace App\Exports\Monitoring;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class MonitoringPspSatker implements FromCollection, WithEvents
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
        $data = $this->data;

        $rows = [
            [null],
            [null, 'Monitoring PSP'],
            [null, $data['satker']->name.' ('.$data['satker']->kode.')'],
            [null],
            [null, 'No', 'Aset', 'Total Keseluruhan'],
            [null, null, null, 'Total', null, 'Sudah PSP', null, null, null, 'Belum PSP'],
            [null, null, null, 'Unit', 'Nilai', 'Unit', '%', 'Nilai', '%', 'Unit', '%', 'Nilai', '%'],
        ];

        $i = 1;
        $jmlData = 0;
        $startData = 8;
        foreach ($data['data'] as $k => $row) {
            $rowNow = $startData + $jmlData;
            if($row->total_nilai == null || $row->total_nilai == 0) {
                $list = [
                    null,
                    $i++,
                    $row->name,
                ];
            } else {
                $list = [
                    null,
                    $i++,
                    $row->name,
                    $row->total_unit,
                    $row->total_nilai,
                    $row->total_unit_psp,
                    '=(F'.$rowNow.'/D'.$rowNow.')*100%',
                    $row->total_nilai_psp,
                    '=(H'.$rowNow.'/E'.$rowNow.')*100%',
                    $row->total_unit_belum_psp,
                    '=(J'.$rowNow.'/D'.$rowNow.')*100%',
                    $row->total_nilai_belum_psp,
                    '=(L'.$rowNow.'/E'.$rowNow.')*100%',
                ];
            }

            $rows[] = $list;
            $jmlData++;
        }
        $this->jmlData = $jmlData;

        $arrTotal = [null, 'Total', null];
        for($i = 'D';$i <= 'M';$i++) {
            if($i == 'G') {
                $arrTotal[] = '=(F'.($startData + $jmlData).'/D'.($startData + $jmlData) .')*100%';
            } else if($i == 'I') {
                $arrTotal[] = '=(H'.($startData + $jmlData).'/E'.($startData + $jmlData) .')*100%';
            } else if($i == 'K') {
                $arrTotal[] = '=(J'.($startData + $jmlData).'/D'.($startData + $jmlData) .')*100%';
            } else if($i == 'M') {
                $arrTotal[] = '=(L'.($startData + $jmlData).'/E'.($startData + $jmlData) .')*100%';
            } else {
                $arrTotal[] = '=SUM(' . $i . $startData . ':' . $i . ($startData + $jmlData - 1) . ')';
            }
        }
        $rows[] = $arrTotal;

        return collect($rows);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $startData = 8;

                $totalRowData = $startData - 1 + count($this->data['data']);

                $endRow = $sheet->getHighestRow();
                $endCol = $sheet->getHighestColumn();

                $sheet->mergeCells('B2:'.$endCol.'2');
                $sheet->mergeCells('B3:'.$endCol.'3');

                $sheet->mergeCells('B5:B7');
                $sheet->mergeCells('C5:C7');
                $sheet->mergeCells('D5:'.$endCol.'5');
                $sheet->mergeCells('D6:E6');
                $sheet->mergeCells('F6:I6');
                $sheet->mergeCells('J6:'.$endCol.'6');

                $sheet->mergeCells('B'.$endRow.':C'.$endRow);
//
                $sheet->getColumnDimension('A')->setWidth($this->convertWidth(3));
                $sheet->getColumnDimension('B')->setWidth($this->convertWidth(5.43));
                $sheet->getColumnDimension('C')->setWidth($this->convertWidth(31));
                $sheet->getColumnDimension('D')->setWidth($this->convertWidth(7.43));
                $sheet->getColumnDimension('E')->setWidth($this->convertWidth(21.71));

                $sheet->getColumnDimension('F')->setWidth($this->convertWidth(7.43));
                $sheet->getColumnDimension('G')->setWidth($this->convertWidth(7.43));
                $sheet->getColumnDimension('H')->setWidth($this->convertWidth(21.71));
                $sheet->getColumnDimension('I')->setWidth($this->convertWidth(7.43));

                $sheet->getColumnDimension('J')->setWidth($this->convertWidth(7.43));
                $sheet->getColumnDimension('K')->setWidth($this->convertWidth(7.43));
                $sheet->getColumnDimension('L')->setWidth($this->convertWidth(21.71));
                $sheet->getColumnDimension('M')->setWidth($this->convertWidth(7.43));

                // Header
                $sheet->getStyle("B2:B3")->applyFromArray([
                    'font'  => [
                        'bold'  => true,
                        'size' => 14
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                ]);

                // Table Header
                $sheet->getStyle("B5:".$endCol."7")->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // Total
                $sheet->getStyle("B$endRow:B".$endRow)->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_RIGHT,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // Total Data
                $sheet->getStyle("D$endRow:".$endCol.$endRow)->applyFromArray([
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // NO Style
                $sheet->getStyle("B".($startData).":B".($totalRowData))->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // Accounting Format
                foreach (['E', 'H', 'L'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"_-;_-@_-');
                }

                // Number Format
                foreach (['D', 'F', 'J'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.$endRow)->getNumberFormat()->setFormatCode('#,##0');
                }

                // Number Format
                foreach (['G', 'I', 'K', 'M'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.$endRow)->getNumberFormat()->setFormatCode('0%;[Red]-0%');
                }

                // Border
                $sheet->getStyle("B5:$endCol" . $endRow)->applyFromArray([
                    'borders' => [
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ]);
            },
        ];
    }

    private function convertWidth(float $width): float
    {
        $width += 0.71;

        return floatval($width);
    }
}
