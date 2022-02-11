<?php

namespace App\Exports\Usulan;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BongkaranExport implements FromCollection, WithEvents
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
            [null, null,  null,  null,  null,  null,  null,  null, 'LAMPIRAN', ':  SURAT SEKRETARIS MAHKAMAH AGUNG - RI'],
            [null, null,  null,  null,  null,  null,  null,  null, 'NOMOR', ':'],
            [null, null,  null,  null,  null,  null,  null,  null, 'TANGGAL', ':'],
            [null],
            ['DAFTAR BARANG MILIK NEGARA YANG DISETUJUI UNTUK DIPINDAHTANGANKAN PADA ' . strtoupper($data['data']->satkerName)],
            [null],
            ['NO', 'NAMA BARANG', 'URAIAN', 'KODE BARANG', 'N U P', 'TAHUN PEROLEHAN', 'JUMLAH', 'HARGA PEROLEHAN (RP)', "NILAI LIMIT\n(RP)", 'LOKASI', 'KETERANGAN'],
            [null],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]
        ];

        $i = 1;
        $jmlData = 0;
        $mergeData = [];
        foreach ($data['barang'] as $k => $row) {
            $uraians = $data['uraians'][$row->idBarang];

            $rows[] = [
                $i++,
                $row->nama_barang,
                $uraians[0]->uraian,
                $row->kode_barang,
                $row->nup,
                $row->tahun_perolehan,
                ($uraians[0]->jumlah + 0).' '.$uraians[0]->satuan,
                (int)$row->nilai_perolehan,
                (int)$data['data']->nilai_taksiran,
                $row->jalan,
                $row->kondisi,
            ];

            $jmlData += count($uraians);
            $mergeData[] = count($uraians);
            foreach ($uraians as $j => $uraian) {
                if($j != 0) {
                    $rows[] = [
                        $i++,
                        null,
                        $uraian->uraian,
                        null,
                        null,
                        null,
                        $uraian->jumlah.' '.$uraian->satuan,
                        null,
                        '',
                        null,
                        null,
                    ];
                }
            }
        }
        $this->jmlData = $jmlData;

        $rows[] = [null, null, null, null, null, 'TOTAL', null, '=SUM(H10:H'.(9+$jmlData).')', '=SUM(I10:I'.(9+$jmlData).')'];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null, null, null, null, null, null, null, null, 'Ditetapkan di : J A K A R T A'];
        $rows[] = [null];
        $rows[] = [null, null, null, null, null, null, null, null, 'SEKRETARIS MAHKAMAH AGUNG RI,'];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null];
        $rows[] = [null, null, null, null, null, null, null, null, 'A.S. PUDJOHARSOYO'];

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
                $sheet->mergeCells('A7:A8');
                $sheet->mergeCells('B7:B8');
                $sheet->mergeCells('C7:C8');
                $sheet->mergeCells('D7:D8');
                $sheet->mergeCells('E7:E8');
                $sheet->mergeCells('F7:F8');
                $sheet->mergeCells('G7:G8');
                $sheet->mergeCells('H7:H8');
                $sheet->mergeCells('I7:I8');
                $sheet->mergeCells('J7:J8');
                $sheet->mergeCells('K7:K8');
                $jmlData = $this->jmlData;
                $sheet->mergeCells('I'.($startData+$jmlData+5).':K'.($startData+$jmlData+5));
                $sheet->mergeCells('I'.($startData+$jmlData+7).':K'.($startData+$jmlData+7));
                $sheet->mergeCells('I'.($startData+$jmlData+13).':K'.($startData+$jmlData+13));

                $sheet->freezePane('A'.$startData);

                $start = $startData;
                foreach ($this->mergeData as $merge) {
                    $sheet->mergeCells('B'.$start.':B'.($start+$merge-1));
                    $sheet->mergeCells('D'.$start.':D'.($start+$merge-1));
                    $sheet->mergeCells('E'.$start.':E'.($start+$merge-1));
                    $sheet->mergeCells('F'.$start.':F'.($start+$merge-1));
                    $sheet->mergeCells('H'.$start.':H'.($start+$merge-1));
                    $sheet->mergeCells('J'.$start.':J'.($start+$merge-1));
                    $sheet->mergeCells('K'.$start.':K'.($start+$merge-1));

                    $start += $merge;
                }
                $sheet->mergeCells('I'.$startData.':I'.($start-1));

                $sheet->getColumnDimension('A')->setWidth($this->convertWidth(5.57));
                $sheet->getColumnDimension('B')->setWidth($this->convertWidth(23.43));
                $sheet->getColumnDimension('C')->setWidth($this->convertWidth(23.43));
                $sheet->getColumnDimension('D')->setWidth($this->convertWidth(18.71));
                $sheet->getColumnDimension('E')->setWidth($this->convertWidth(11.57));
                $sheet->getColumnDimension('F')->setWidth($this->convertWidth(11.57));
                $sheet->getColumnDimension('G')->setWidth($this->convertWidth(16));
                $sheet->getColumnDimension('H')->setWidth($this->convertWidth(19.43));
                $sheet->getColumnDimension('I')->setWidth($this->convertWidth(16));
                $sheet->getColumnDimension('J')->setWidth($this->convertWidth(34.43));
                $sheet->getColumnDimension('K')->setWidth($this->convertWidth(16));


                $sheet->getStyle("A7:".$endCol.'8')->getAlignment()->setWrapText(true);

                for ($i = $startData;$i < ($startData + $jmlData - 1);$i++){
                    $sheet->getRowDimension($i)->setRowHeight(31);
                }

                $sheet->getStyle("I1:J3")->applyFromArray([
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

                $sheet->getStyle("B$startData:B".($startData+$jmlData-1))->getAlignment()->setWrapText(true);
                $sheet->getStyle("J$startData:J".($startData+$jmlData-1))->getAlignment()->setWrapText(true);

                foreach (['A', 'B', 'D', 'E', 'F', 'G', 'J', 'K'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.($startData+ $jmlData -1))->applyFromArray([
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        )
                    ]);
                }

                foreach (['H', 'I'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.($startData+ $jmlData))->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)');
                    $sheet->getStyle($row."$startData:".$row.($startData+ $jmlData))->applyFromArray([
                        'alignment' => array(
                            'vertical' => Alignment::VERTICAL_CENTER,
                        )
                    ]);
                }

                $sheet->getStyle("C$startData:C".($startData+ $jmlData -1))->applyFromArray([
                    'alignment' => array(
                        'vertical' => Alignment::VERTICAL_CENTER,
                    )
                ]);

                $sheet->getStyle("F".($startData+ $jmlData).":I".($startData+ $jmlData))->applyFromArray([
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                $sheet->getStyle("I".($startData+$jmlData+5).":K".($startData+$jmlData+15))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $sheet->getStyle("I".($startData+$jmlData+7).":K".($startData+$jmlData+15))->applyFromArray([
                    'font'  => [
                        'bold'  => true
                    ]
                ]);
//
                $sheet->getStyle("A7:$endCol" . ($startData+$jmlData))->applyFromArray([
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
