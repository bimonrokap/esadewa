<?php

namespace App\Exports;

use App\Model\UsulanBarang;
use Maatwebsite\Excel\Concerns\FromCollection;

class BarangExport implements FromCollection
{
    private $id, $type;

    public function __construct($id, $type)
    {
        $this->id = $id;
        $this->type = $type;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        $data[] = ['No', 'NUP', 'Kode Barang', 'Nama Barang', 'Nilai Perolehan', 'Tgl Perolehan'];
        $type = $this->type;
        $table = 'usulan_barangs';

        $model = UsulanBarang::where('id_object', $this->id)->whereObjectType($type);

        $test = $model
            ->join('view_barang', function ($join) use($table) {
                $join->on('view_barang.id', '=', $table . '.id_barang')
                    ->on('view_barang.category', '=', $table . '.category');
            })
            ->get(['nup', 'kode_barang', 'nama_barang', 'view_barang.nilai_perolehan', 'tgl_perolehan'])->map(function ($item, $key){
                $data[] = $key + 1;
                $data[] = $item['nup'];
                $data[] = $item['kode_barang'];
                $data[] = $item['nama_barang'];
                $data[] = $item['nilai_perolehan'];
                $data[] = $item['tgl_perolehan'];

                return $data;
            });
        $data = array_merge($data, $test->toArray());

        return collect($data);
    }
}
