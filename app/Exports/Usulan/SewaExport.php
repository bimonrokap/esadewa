<?php

namespace App\Exports\Usulan;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SewaExport implements FromCollection, WithEvents
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
            [null, null,  null,  null,  null,  'LAMPIRAN', ':  SURAT KEPUTUSAN SEKRETARIS MAHKAMAH AGUNG - RI'],
            [null, null,  null,  null,  null,  'NOMOR', ':'],
            [null, null,  null,  null,  null,  'TANGGAL', ':'],
            [null],
            ['DAFTAR BARANG MILIK NEGARA BERUPA SEBAGIAN TANAH DAN/ATAU BANGUNAN'],
            ['YANG DISETUJUI UNTUK DISEWAKAN PADA ' . strtoupper($data['data']->satkerName)],
            [null],
            ['NO', 'KODE BARANG', 'N U P', 'NAMA BARANG', 'LOKASI BARANG', 'LUAS YANG DISEWA', 'JANGKA WAKTU', 'PERIODE', "NILAI SEWA", 'PENYEWA'],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        ];

        $i = 1;
        $jmlData = 0;
        $mergeData = [];
        foreach ($data['barang'] as $k => $row) {
            $date = Carbon::parse($row->letter_date);
            $month = $date->copy()->addMonth($data['data']->periode);

            if($k > 0) {
                $list = [
                    $i++,
                    (string)$row->kode_barang,
                    $row->nup,
                    $row->nama_barang
                ];
            } else {
                $list = [
                    $i++,
                    $row->kode_barang,
                    $row->nup,
                    $row->nama_barang,
                    $data['data']->lokasi,
                    $data['data']->luas_asset.' m2',
                    $data['data']->periode % 12 == 0 ? ($data['data']->periode / 12) . ' Tahun' : $data['data']->periode . ' Bulan',
                    $data['data']->periode % 12 == 0 ? ($date->year . ' - ' . ($date->year + ($data['data']->periode / 12))) : ($date->format('m-Y') . ' - ' . $month->format('m-Y')),
                    $data['data']->nilai_sewa,
                    $data['data']->identitas_penyewa,
                ];
            }

            $rows[] = $list;
        }
        $this->jmlData = $jmlData;

        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null, null, null, null, null, null, null, 'Ditetapkan di : J A K A R T A'];
        $rows[] = [null];
        $rows[] = [null, null, null, null, null, null, null, 'SEKRETARIS MAHKAMAH AGUNG RI,'];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null, null, null, null, null, null, null, 'HASBI HASAN'];

        $this->mergeData = $mergeData;

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

                $startData = 10;

                $endRow = $sheet->getHighestRow();
                $endCol = $sheet->getHighestColumn();

                $sheet->mergeCells('A5:'.$endCol.'5');
                $sheet->mergeCells('A6:'.$endCol.'6');

                $sheet->freezePane('A'.$startData);

                $totalRowData = $startData - 1 + count($this->data['barang']);

                $sheet->mergeCells('E'.$startData.':E'.($totalRowData));
                $sheet->mergeCells('F'.$startData.':F'.($totalRowData));
                $sheet->mergeCells('G'.$startData.':G'.($totalRowData));
                $sheet->mergeCells('H'.$startData.':H'.($totalRowData));
                $sheet->mergeCells('I'.$startData.':I'.($totalRowData));
                $sheet->mergeCells('J'.$startData.':J'.($totalRowData));

                $sheet->mergeCells('H'.($totalRowData+5).':J'.($totalRowData+5));
                $sheet->mergeCells('H'.($totalRowData+7).':J'.($totalRowData+7));
                $sheet->mergeCells('H'.($totalRowData+13).':J'.($totalRowData+13));

                $sheet->getColumnDimension('A')->setWidth($this->convertWidth(5.57));
                $sheet->getColumnDimension('B')->setWidth($this->convertWidth(14.57));
                $sheet->getColumnDimension('C')->setWidth($this->convertWidth(7.29));
                $sheet->getColumnDimension('D')->setWidth($this->convertWidth(29.29));
                $sheet->getColumnDimension('E')->setWidth($this->convertWidth(29.29));
                $sheet->getColumnDimension('F')->setWidth($this->convertWidth(9.57));
                $sheet->getColumnDimension('G')->setWidth($this->convertWidth(9.57));
                $sheet->getColumnDimension('H')->setWidth($this->convertWidth(9.57));
                $sheet->getColumnDimension('I')->setWidth($this->convertWidth(16));
                $sheet->getColumnDimension('J')->setWidth($this->convertWidth(20));


                $sheet->getStyle("A8:".$endCol.'8')->getAlignment()->setWrapText(true);

                for ($i = $startData;$i < $totalRowData;$i++){
                    $sheet->getRowDimension($i)->setRowHeight(31);
                }

                $sheet->getStyle("F1:G3")->applyFromArray([
                    'font'  => [
                        'bold'  => true
                    ]
                ]);
                $sheet->getStyle("A5:".$endCol."9")->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                $sheet->getStyle("D$startData:D".($totalRowData))->getAlignment()->setWrapText(true);
                $sheet->getStyle("E$startData:E".($totalRowData))->getAlignment()->setWrapText(true);
                $sheet->getStyle("J$startData:J".($totalRowData))->getAlignment()->setWrapText(true);

                foreach (['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.$totalRowData)->applyFromArray([
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        )
                    ]);
                }

                foreach (['I'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.($totalRowData))->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)');
                }

                $sheet->getStyle("J$startData:J".($totalRowData))->applyFromArray([
                    'alignment' => array(
                        'vertical' => Alignment::VERTICAL_CENTER,
                    )
                ]);

                $sheet->getStyle("H".($totalRowData+5).":K".($totalRowData+15))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $sheet->getStyle("A8:$endCol" . ($totalRowData))->applyFromArray([
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
