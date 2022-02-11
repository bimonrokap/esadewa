<?php

namespace App\Http\Controllers;

use App\Model\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    protected $baseFilter = [
        'lingkungan' => 'lingkungan',
        'wilayah' => 'wilayah',
        'kondisi' => 'kondisi',
        'psp' => 'psp'
    ];
    protected $nilaiPerolehan = 'nilai_perolehan';
    protected $model, $config, $layout;
    protected $hasPsp = true;
    protected $barangJoin = false;
    protected $categoryAsset = 1;

    protected function canLaporBmn($data)
    {
        return $data->kode_barang . (\Permission::can('create-lapor') ? ' <i class="la la-info-circle info-asset" style="color: #0093ec;" data-url="'.(route('admin.lapor.detailAsset', ['id' => $data->id, 'category' => $this->categoryAsset])).'" ></i>' : '');
    }

    protected function generalFilter()
    {
        $data['lingkungan'] = ['PN' => 'Peradilan Umum', 'PA' => 'Peradilan Agama', 'PM' => 'Peradilan Militer', 'PT' => 'Peradilan Tata Usaha Negara'];
        $data['wilayah'] = Wilayah::get();
        $data['kondisi'] = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
        $data['psp'] = ['Sudah', 'Belum'];
        $data['sertifikat'] = ['Sudah', 'Belum'];
        $data['kendaraan_type'] = ['Roda 4', 'Roda 2', 'Lainnya'];

        return $data;
    }

    /**
     * @param Request $request
     * @param $model
     * @return array
     */
    protected function searchUsulan(Request $request, $model): array
    {
        $this->nilaiPerolehan = $this->model->getTable() . '.' . $this->nilaiPerolehan;
        $hasUsulan = $request->has('usulan');
        if ($hasUsulan) {
            $categoryObject = $request->input('categoryObject');
            switch ($categoryObject) {
                case 1:
                    $model->where($this->nilaiPerolehan, '<=', 100000000)
                        ->whereNotIn(DB::raw('SUBSTRING('.($this->barangJoin ? 'b.kode' : 'kode_barang').', 1, 5)'), [30201, 30203, 30204, 30205]);
                    break;
                case 2:
                    $model->where($this->nilaiPerolehan, '<=', 10000000000);
                    break;
                case 3:
                    $model->where($this->nilaiPerolehan, '>', 10000000000)->where($this->nilaiPerolehan, '<=', 50000000000);
                    break;
                case 4:
                    $model->where($this->nilaiPerolehan, '>', 50000000000);
                    break;
            }


            switch ($request->input('usulan')) {
                case 'penjualan':
                    if($this->hasPsp) {
                        $model->where(function ($q){
                            $q->where('no_psp', '!=', null)
                                ->where('no_psp', '!=', '-');
                        })->where('kondisi', 'Rusak Berat')
                            ->where('nilai_perolehan', '<=', 100000000);
                    }
                    break;
                case 'bongkaran':
                    if($this->hasPsp) {
                        $model->where(function ($q){
                            $q->where('no_psp', '!=', null)
                                ->where('no_psp', '!=', '-');
                        });
                    }
                    break;
                case 'sertipikat':
                    if($request->has('addParam')) {
                        $param = $request->input('addParam');

                        foreach ($param as $key => $row) {
                            $model->where($key, $row);
                        }
                    }
                    break;
                case 'penghapusan':
                    // $model->where($this->nilaiPerolehan, '>', 100000000);
                    break;
            }
        }

        return [$model, $hasUsulan];
    }

    /**
     * @return array
     */
    public function getTableHeader(): array
    {
        return $this->tableHeader;
    }
}
