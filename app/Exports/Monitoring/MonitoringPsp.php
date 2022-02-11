<?php

namespace App\Exports\Monitoring;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class MonitoringPsp implements FromCollection, WithEvents
{
    private $data;
    private $category;
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function collection()
    {
        $data = $this->data;
        $categories = $data['categories']->pluck('name', 'id');

        $rowHeader1 = [null, 'No', 'Kode Satker', 'Nama Satker'];
        $rowHeader2 = [null, null, null, null];
        $rowHeader3 = [null, null, null, null];
        foreach ($categories as $category) {
            $rowHeader1 = array_merge($rowHeader1, [$category, null, null, null, null, null, null, null, null, null, null]);
            $rowHeader2 = array_merge($rowHeader2, ['Total', null, 'Sudah PSP', null, null, null, 'Belum PSP', null, null, null, null]);
            $rowHeader3 = array_merge($rowHeader3, ['Unit', 'Nilai', 'Unit', '%', 'Nilai', '%', 'Unit', '%', 'Nilai', '%', null]);
        }
        $rowHeader1 = array_merge($rowHeader1, ['Total keseluruhan', null, null, null, null, null, null, null, null, null, 'Kategori']);
        $rowHeader2 = array_merge($rowHeader2, ['Total', null, 'Sudah PSP', null, null, null, 'Belum PSP']);
        $rowHeader3 = array_merge($rowHeader3, ['Unit', 'Nilai', 'Unit', '%', 'Nilai', '%', 'Unit', '%', 'Nilai', '%']);

        $rows = [
            [null],
            [null, 'Monitoring PSP'],
            [null],
            $rowHeader1,
            $rowHeader2,
            $rowHeader3,
        ];

        $i = 1;
        $jmlData = 0;
        $startData = 7;
        $categories[0] = 'Keseluruhan';
        foreach ($data['satkers'] as $k => $row) {
            $rowNow = $startData + $jmlData;

            $list = [
                null,
                $i++,
                $row->kode,
                $row->name,
            ];

            $strCol = 'E';
            foreach ($categories as $key => $category) {
                if(isset($data['data'][str_slug($category)])){
                    $tmpData = $data['data'][str_slug($category)];

                    if(isset($tmpData[$row->kode])) {
                        $tmpS = $tmpData[$row->kode];

                        $unitStart = $strCol;
                        $nilaiStart = ++$strCol;

                        $columnNumber = Coordinate::columnIndexFromString($strCol) + 1;
                        $strCol = Coordinate::stringFromColumnIndex($columnNumber);
                        $tmpCol = Coordinate::stringFromColumnIndex($columnNumber + 4);

                        $tmpList = [
                            $tmpS->total_unit,
                            $tmpS->total_nilai,
                            $tmpS->total_unit_psp,
                            '=('.$strCol++.$rowNow.'/'.$unitStart.$rowNow.')*100%',
                            $tmpS->total_nilai_psp,
                            '=('.++$strCol.$rowNow.'/'.$nilaiStart.$rowNow.')*100%',
                            $tmpS->total_unit_belum_psp,
                            '=('.$tmpCol++.$rowNow.'/'.$unitStart.$rowNow.')*100%',
                            $tmpS->total_nilai_belum_psp,
                            '=('.++$tmpCol.$rowNow.'/'.$nilaiStart.$rowNow.')*100%',
                        ];
                        $persenNilaiPsp = Coordinate::stringFromColumnIndex($columnNumber + 3);

                        if($category == 'Keseluruhan') {
                            $tmpList[] = '=IF('.$persenNilaiPsp.$rowNow.'>90%,"Baik",IF(AND('.$persenNilaiPsp.$rowNow.'>70%,'.$persenNilaiPsp.$rowNow.'<=90%),"Sedang",IF(AND('.$persenNilaiPsp.$rowNow.'>50%,'.$persenNilaiPsp.$rowNow.'<=70%),"Buruk","Sangat Buruk")))';
                        } else {
                            $tmpList[] = null;
                        }

                        $strCol = Coordinate::stringFromColumnIndex($columnNumber + 9);

                        unset($data['data'][str_slug($category)][$row->kode]);
                    } else {
                        $columnNumber = Coordinate::columnIndexFromString($strCol) + 11;
                        $newColumn = Coordinate::stringFromColumnIndex($columnNumber);

                        $tmpList = [null, null, null, null, null, null, null, null, null, null, null];

                        $strCol = $newColumn;
                    }
                }

                $list = array_merge($list, $tmpList);
            }

            $rows[] = $list;
            $jmlData++;
        }
        $this->jmlData = $jmlData;

        return collect($rows);
    }

    function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }


    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $startData = 7;

                $totalRowData = $startData - 1 + count($this->data['satkers']);

                $endRow = $sheet->getHighestRow();
                $endCol = $sheet->getHighestColumn();

                $sheet->mergeCells('B2:'.$endCol.'2');
                $sheet->freezePane('E7');

                $sheet->mergeCells('B4:B6');
                $sheet->mergeCells('C4:C6');
                $sheet->mergeCells('D4:D6');
                $sheet->mergeCells($endCol.'4:'.$endCol.'6');

                $strCol = 'E';
                $categories = $this->data['categories'];
                $categories[] = 'Tes';
                foreach ($categories as $category) {
                    $columnNumber = Coordinate::columnIndexFromString($strCol) + 10;
                    $newColumn1 = Coordinate::stringFromColumnIndex($columnNumber - 1);
                    $newColumn2 = Coordinate::stringFromColumnIndex($columnNumber - 5);
                    $newColumn3 = Coordinate::stringFromColumnIndex($columnNumber - 1);

                    $sheet->mergeCells($strCol.'4:'.$newColumn1.'4');
                    $sheet->mergeCells($strCol.'5:'.(++$strCol).'5');
                    $sheet->mergeCells(++$strCol.'5:'.$newColumn2.'5');
                    $sheet->mergeCells(++$newColumn2.'5:'.$newColumn3.'5');

                    $strCol = Coordinate::stringFromColumnIndex($columnNumber + 1);
                }

                $sheet->getColumnDimension('A')->setWidth($this->convertWidth(3));
                $sheet->getColumnDimension('B')->setWidth($this->convertWidth(5.43));
                $sheet->getColumnDimension('C')->setWidth($this->convertWidth(22.57));
                $sheet->getColumnDimension('D')->setWidth($this->convertWidth(47.43));

                $strCol = 'E';
                foreach ($categories as $key => $category) {
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(21.71));

                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(21.71));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));

                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(21.71));
                    $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(7.43));
                    if(count($categories) != ($key + 1)) {
                        $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(3.57));
                    } else {
                        $sheet->getColumnDimension($strCol++)->setWidth($this->convertWidth(20));
                    }
                }

                // Header
                $sheet->getStyle("B2:B2")->applyFromArray([
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
                $sheet->getStyle("B4:".$endCol."6")->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
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

                // Kategori
                $sheet->getStyle($endCol.$startData.":".$endCol.$totalRowData)->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // Wrap Text
                $sheet->getStyle("D".($startData).":D".($totalRowData))->getAlignment()->setWrapText(true);

                // Start Border
                $sheet->getStyle("B4:D" . $endRow)->applyFromArray([
                    'borders' => [
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ]);

                // Accounting Format
                $strCol = 'E';
                foreach ($categories as $k => $category) {
                    $columnNumber = Coordinate::columnIndexFromString($strCol) + 10;
                    if(count($categories) - 1 == $k) {
                        $newColumn = Coordinate::stringFromColumnIndex($columnNumber);
                    } else {
                        $newColumn = Coordinate::stringFromColumnIndex($columnNumber - 1);
                    }

                    $sheet->getStyle($strCol."4:"  . $newColumn . $endRow)->applyFromArray([
                        'borders' => [
                            'inside' => [
                                'borderStyle' => Border::BORDER_THIN
                            ],
                            'outline' => [
                                'borderStyle' => Border::BORDER_THIN
                            ]
                        ]
                    ]);

                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"_-;_-@_-');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('0%;[Red]-0%');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"_-;_-@_-');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('0%;[Red]-0%');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('#,##0');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('0%;[Red]-0%');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;-Rp* #,##0_-;_-Rp* "-"_-;_-@_-');
                    $sheet->getStyle($strCol."$startData:".$strCol++.$endRow)->getNumberFormat()->setFormatCode('0%;[Red]-0%');
                    $strCol++;
                }
            },
        ];
    }

    private function convertWidth(float $width): float
    {
        $width += 0.71;

        return floatval($width);
    }
}
