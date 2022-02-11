<?php

namespace App\Exports\Monitoring;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;


class MonitoringPenghapusan implements FromCollection, WithEvents
{
    private $data;
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

        $rows = [
            [null],
            [null, 'No', 'Satuan Kerja', 'Dokumen Penghapusan', null, null, null, 'Transaksi Penghapusan', null, null, 'Selisih'],
            [null, null, null, 'Jumlah SK', 'Unit', 'NIlai', null, 'Unit', 'NIlai', null, 'Unit', 'NIlai']
        ];

        $nilai = [ 0 => [], 1 => [], 2 => [], 3 => [], 4 => [], 5 => [], 6 => [] ];
        foreach ($data['satkers'] as $k => $satker) {
            if(isset($data['data'][$satker->kode])){
                $nilai[0][] = $data['data'][$satker->kode]->sk * -1;
                $nilai[1][] = $data['data'][$satker->kode]->jumlah_barang * -1;
                $nilai[2][] = $data['data'][$satker->kode]->nilai_perolehan * -1;
            } else {
                $nilai[0][] = $nilai[1][] = $nilai[2][] = null;
            }
            $nilai[3][] = $satker->kuantitas;
            $nilai[4][] = $satker->nilai;

            $nilai[5][] = $nilai[1][$k] == null && $satker->kuantitas == null ? null :
                ($nilai[1][$k] != null && $satker->kuantitas != null ? $satker->kuantitas - ($nilai[1][$k] * -1) :
                    ($nilai[1][$k] == null ? $satker->kuantitas : $nilai[1][$k] * -1));
            $nilai[6][] = $nilai[2][$k] == null && $satker->nilai == null ? null :
                ($nilai[2][$k] != null && $satker->nilai != null ? $satker->nilai - ($nilai[2][$k] * -1) :
                    ($nilai[2][$k] == null ? $satker->nilai : $nilai[2][$k] * -1));

            $row = [null, ($k+1), $satker->name . "\n(" . $satker->kode . ')'];

            $j = 0;
            for($i=0;$i<=8;$i++){
                if(in_array($i, [3,6])){
                    $row[] = null;
                } else {
                    $row[] = $nilai[$j][$k] == null ? '-' : $nilai[$j][$k];
                    $j++;
                }
            }
            $rows[] = $row;
        }

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

                $startData = 4;

                $endRow = $sheet->getHighestRow();
                $endCol = $sheet->getHighestColumn();

                $sheet->freezePane('D4');

                $sheet->mergeCells('B2:B3');
                $sheet->mergeCells('C2:C3');
                $sheet->mergeCells('D2:F2');
                $sheet->mergeCells('G2:G3');
                $sheet->mergeCells('H2:I2');
                $sheet->mergeCells('J2:J3');
                $sheet->mergeCells('K2:L2');

                $sheet->getColumnDimension('A')->setWidth($this->convertWidth(3));
                $sheet->getColumnDimension('B')->setWidth($this->convertWidth(5));
                $sheet->getColumnDimension('C')->setWidth($this->convertWidth(40));

                $sheet->getColumnDimension('D')->setWidth($this->convertWidth(10));
                $sheet->getColumnDimension('E')->setWidth($this->convertWidth(10));
                $sheet->getColumnDimension('F')->setWidth($this->convertWidth(16));
                $sheet->getColumnDimension('G')->setWidth($this->convertWidth(5));

                $sheet->getColumnDimension('H')->setWidth($this->convertWidth(10));
                $sheet->getColumnDimension('I')->setWidth($this->convertWidth(16));
                $sheet->getColumnDimension('J')->setWidth($this->convertWidth(5));

                $sheet->getColumnDimension('K')->setWidth($this->convertWidth(10));
                $sheet->getColumnDimension('L')->setWidth($this->convertWidth(16));

                // Table Header
                $sheet->getStyle("B2:".$endCol."3")->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // NO Style
                $sheet->getStyle("B".$startData.":B".$endRow)->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                // Wrap Text
                $sheet->getStyle("C".$startData.":C".$endRow)->getAlignment()->setWrapText(true);

                // Start Border
                $sheet->getStyle("B2:" . $endCol . $endRow)->applyFromArray([
                    'alignment' => array(
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'borders' => [
                        'inside' => [
                            'borderStyle' => Border::BORDER_THIN
                        ],
                        'outline' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
                    ]
                ]);


                $sheet->getStyle('F'.$startData.':F'.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;Rp*  (#,##0)_-;_-Rp* "-"_-;_-@_-');
                $sheet->getStyle('I'.$startData.':I'.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;Rp*  (#,##0)_-;_-Rp* "-"_-;_-@_-');
                $sheet->getStyle('L'.$startData.':L'.$endRow)->getNumberFormat()->setFormatCode('_-Rp* #,##0_-;Rp*  (#,##0)_-;_-Rp* "-"_-;_-@_-');
            },
        ];
    }

    private function convertWidth(float $width): float
    {
        $width += 0.71;

        return floatval($width);
    }
}
