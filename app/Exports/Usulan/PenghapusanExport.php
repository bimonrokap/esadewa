<?php

namespace App\Exports\Usulan;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PenghapusanExport implements FromCollection, WithEvents
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
            [null, null, null, null, null, null, 'LAMPIRAN', ':  SURAT KEPUTUSAN SEKRETARIS MAHKAMAH AGUNG - RI'],
            [null, null, null, null, null, null, 'NOMOR', ':'],
            [null, null, null, null, null, null, 'TANGGAL', ':'],
            [null],
            ['DAFTAR BARANG MILIK NEGARA YANG DISETUJUI UNTUK DIHAPUS PADA ' . strtoupper($data['data']->satkerName)],
            [null],
            ['NO', 'NAMA BARANG', 'MERK/TYPE', 'KODE BARANG', 'N U P', 'TAHUN PEROLEHAN', 'JUMLAH', "HARGA PEROLEHAN \n(RP)", "NILAI LIMIT\n(RP)", "KONDISI"],
            [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
        ];

        $i = 1;
        $jmlData = 0;
        foreach ($data['barang'] as $k => $row) {
            $list = [
                $i++,
                $row->nama_barang,
                $row->merk,
                $row->kode_barang,
                $row->nup,
                $row->tahun_perolehan,
                (int)$row->kuantitas,
                (int)$row->nilai_perolehan,
                0,
                $row->kondisi,
            ];

            $rows[] = $list;
            $jmlData++;
        }
        $this->jmlData = $jmlData;


        $rows[] = [null, null, 'JUMLAH', NULL, NULL, null, '=SUM(G9:G'.(9+$jmlData-1).')', '=SUM(H9:H'.(9+$jmlData-1).')', '=SUM(I9:I'.(9+$jmlData-1).')'];
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
        $rows[] = [null, null, null, null, null, null, null, 'Dr. H. HASBI, M.H.'];

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

                $startData = 9;

                $endRow = $sheet->getHighestRow();
                $endCol = $sheet->getHighestColumn();

                $sheet->mergeCells('A5:'.$endCol.'5');
                $sheet->mergeCells('A6:'.$endCol.'6');

                $sheet->freezePane('A'.$startData);

                $totalRowData = $startData - 1 + count($this->data['barang']);

                $sheet->mergeCells('H'.($totalRowData+5).':J'.($totalRowData+5));
                $sheet->mergeCells('H'.($totalRowData+7).':J'.($totalRowData+7));
                $sheet->mergeCells('H'.($totalRowData+13).':J'.($totalRowData+13));

                $sheet->getColumnDimension('A')->setWidth($this->convertWidth(5.57));
                $sheet->getColumnDimension('B')->setWidth($this->convertWidth(40));
                $sheet->getColumnDimension('C')->setWidth($this->convertWidth(22.14));
                $sheet->getColumnDimension('D')->setWidth($this->convertWidth(17.29));
                $sheet->getColumnDimension('E')->setWidth($this->convertWidth(13.29));
                $sheet->getColumnDimension('F')->setWidth($this->convertWidth(17.29));
                $sheet->getColumnDimension('G')->setWidth($this->convertWidth(13.29));
                $sheet->getColumnDimension('H')->setWidth($this->convertWidth(19.86));
                $sheet->getColumnDimension('I')->setWidth($this->convertWidth(12.57));
                $sheet->getColumnDimension('J')->setWidth($this->convertWidth(31.43));


                $sheet->getStyle("A7:".$endCol.'8')->getAlignment()->setWrapText(true);

                $sheet->getStyle("G1:H3")->applyFromArray([
                    'font'  => [
                        'bold'  => true
                    ]
                ]);
                $sheet->getStyle("A5:".$endCol."8")->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);
                $sheet->getStyle("C".($totalRowData+1).":G".($totalRowData+1))->applyFromArray([
                    'alignment' => array(
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ),
                    'font'  => [
                        'bold'  => true
                    ]
                ]);
                $sheet->getStyle("H".($totalRowData+1).":I".($totalRowData+1))->applyFromArray([
                    'font'  => [
                        'bold'  => true
                    ]
                ]);

                foreach (['A', 'D', 'E', 'F', 'G', 'J'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.$totalRowData)->applyFromArray([
                        'alignment' => array(
                            'horizontal' => Alignment::HORIZONTAL_CENTER,
                            'vertical' => Alignment::VERTICAL_CENTER,
                        )
                    ]);
                }

                foreach (['H', 'I'] as $row) {
                    $sheet->getStyle($row."$startData:".$row.($totalRowData+1))->getNumberFormat()->setFormatCode('_(* #,##0_);_(* (#,##0);_(* "-"_);_(@_)');
                }

                $sheet->getStyle("H".($totalRowData+5).":K".($totalRowData+15))->applyFromArray([
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ]
                ]);

                $sheet->getStyle("A7:$endCol" . ($totalRowData+1))->applyFromArray([
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
