<?php

namespace App\Http\Controllers;

use App\Model\Bongkaran\BongkaranBarang;
use App\Model\Bongkaran\BongkaranFoto;
use App\Model\CategoryAsset;
use App\Model\FileTmp;
use App\Model\ImageTmp;
use App\Model\Pengadaan\Usulan\PengadaanPembangunanBarang;
use App\Model\Pengadaan\Usulan\PengadaanPembangunanGambar;
use App\Model\Pengadaan\Usulan\PengadaanPenawaranFoto;
use App\Model\Pengadaan\Usulan\PengadaanRenovasiFoto;
use App\Model\Pengadaan\Usulan\PengadaanRenovasiGambar;
use App\Model\Penghapusan\PenghapusanBarang;
use App\Model\Penjualan\PenjualanBarang;
use App\Model\Penjualan\PenjualanFoto;
use App\Model\Sewa\SewaBarang;
use App\Model\Sewa\SewaFoto;
use Illuminate\Http\Request;

class UsulanController extends Controller
{

    const maxFoto = 10;
    protected $model, $config, $layout, $objName;

    /**
     * @param $usulan
     * @param null $objName
     * @return \Illuminate\Support\Collection
     */
    public function usulanBarang($usulan, $objName = null)
    {
        if($objName == null) {
            $objName = $this->objName;
        }

        $categories = CategoryAsset::whereActive(1)->get()->pluck('table_name', 'id');
        $groups = $usulan->barangs()->select('id_asset', 'id_category_asset', 'ord')->get()->groupBy('id_category_asset');
        $tmpData = collect([]);
        foreach ($groups as $k => $group)
        {
            $table = $categories[$k];
            $idCol = '';
            switch ($objName) {
                case 'penjualan': $strictModel = new PenjualanBarang(); $idCol = 'id_penjualan'; break;
                case 'bongkaran': $strictModel = new BongkaranBarang(); $idCol = 'id_bongkaran'; break;
                case 'penghapusan': $strictModel = new PenghapusanBarang(); $idCol = 'id_penghapusan'; break;
                case 'sewa': $strictModel = new SewaBarang(); $idCol = 'id_sewa'; break;
                case 'pengadaan-pembangunan': $strictModel = new PengadaanPembangunanBarang(); $idCol = 'id_pengadaan_pembangunan'; break;
            }

            $selectAr = [$table.'.id', 'kode_barang', 'nama_barang', $table.'.nilai_perolehan', 'id_category_asset', 'category_assets.name', 'nup', 'ord'];
            if($objName == 'bongkaran') {
                $selectAr = array_merge($selectAr, ['bongkaran_barangs.id as idBarang', 'bongkaran_barangs.luas_bangunan', \DB::raw('year(tgl_perolehan) as tahun_perolehan'), 'jalan', 'kondisi']);
            } else if ($objName == 'penghapusan') {
                $selectAr = array_merge($selectAr, ['merk', 'kuantitas', \DB::raw('year(tgl_perolehan) as tahun_perolehan'), 'kondisi']);
            } else if ($objName == 'penjualan') {
                $selectAr = array_merge($selectAr, ['merk', 'kuantitas', \DB::raw('year(tgl_perolehan) as tahun_perolehan'), 'kondisi']);
            }

            $data = $strictModel->where($idCol, $usulan->id)
                ->join($table, \DB::raw("CONCAT_WS('-', $table.kode_satker, $table.kode_barang, $table.nup)"), 'id_asset')
                ->join('category_assets', 'category_assets.id', '=', $strictModel->getTable().'.id_category_asset')
                ->select($selectAr)
                ->get();

            $tmpData = $tmpData->merge($data);
        }

        return $tmpData->sortBy('ord')->values();
    }

    /**
     * @param $id
     * @param $category
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function findBarang($id, $category)
    {
        $category = CategoryAsset::find($category);
        return \DB::table($category->table_name)->where('id', $id)->first();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function imageUpload(Request $request, $id)
    {
        $validate = [
            'file' => 'required|mimes:jpg,jpeg,png|max:3000'
        ];
        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($request, $id) {
                $file = $request->file("file");
                $fileName = time().'-'.$file->getClientOriginalName();
                $location = ImageTmp::imageLocation();
                if(!file_exists($location)){
                    mkdir($location, 0755, true);
                }

                $existImage = 0;
                $isAssetConstraint = false;
                $aset = $request->input('aset');
                $maxFoto = $aset * self::maxFoto;
                $type = $request->input('type', 'penjualan');

                if($request->has('id') && $request->input("id") != 0) {
                    switch ($type) {
                        case 'penjualan':
                            $existImage = PenjualanFoto::where('id_penjualan', $request->input('id'))->count();
                            break;
                        case 'sewa':
                            $existImage = SewaFoto::where('id_sewa', $request->input('id'))->count();
                            break;
                        case 'bongkaran':
                            $existImage = BongkaranFoto::where('id_bongkaran', $request->input('id'))->count();
                            break;
                    }
                }

                switch ($type) {
                    case 'penjualan':
                        $isAssetConstraint = true;
                        break;
                    default:
                        $maxFoto = self::maxFoto;
                }

                if($isAssetConstraint && $aset == 0) {
                    return $res = [
                        'status'  => 0,
                        'message' => 'Pilih benda sebelum upload gambar',
                        'statusCode' => 400
                    ];
                } else {
                    $jml = ImageTmp::where("uuid", $id)->count() + $existImage;
                    if($jml >= $maxFoto) {
                        return $res = [
                            'status'  => 0,
                            'message' => 'Jumlah foto melebihi dari maximal.',
                            'statusCode' => 400
                        ];
                    }
                }

                $file->move($location, $fileName);

                $status = ImageTmp::create([
                    'uuid' => $id,
                    'file' => $fileName
                ]);

                if ($status) {
                    $res = [
                        'id' => $status->id,
                        'status'  => 1,
                        'message' => 'Berhasil menambahkan Foto Barang.',
                        'fileName' => $fileName,
                        'statusCode' => 200
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menambahkan Foto Barang',
                        'statusCode' => 400
                    ];
                }

                return $res;
            });
        } else {
            $messages = $validator->errors()->all('<li>:message</li>');
            $res = [
                'status'  => 2,
                'message' => '<ul class="m--marginless">' . implode('', $messages) . '</ul>',
                'statusCode' => 400
            ];
        }

        return response($res, $res['statusCode']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Throwable
     */
    public function fileUpload(Request $request, $id)
    {
        $type = $request->input('type');
        $maxFile = 5;
        if($type == 'pengadaan-pembangunan') {
            $validate = [
                'file' => 'required|mimes:pdf|max:30000'
            ];
        } else {
            $validate = [
                'file' => 'required|mimes:pdf|max:30000'
            ];
        }

        $validator = \Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $res = \DB::transaction(function () use ($request, $id, $type, $maxFile) {
                $file = $request->file("file");
                $fileName = time().'-'.$file->getClientOriginalName();
                $location = FileTmp::location();
                if(!file_exists($location)){
                    mkdir($location, 0755, true);
                }

                $existImage = 0;
                $jml = FileTmp::where("uuid", $id)->count() + $existImage;
                if($jml >= $maxFile) {
                    return $res = [
                        'status'  => 0,
                        'message' => 'Jumlah file melebihi dari maximal.',
                        'statusCode' => 400
                    ];
                }

                $file->move($location, $fileName);

                $status = FileTmp::create([
                    'uuid' => $id,
                    'file' => $fileName
                ]);

                if ($status) {
                    $res = [
                        'id' => $status->id,
                        'status'  => 1,
                        'message' => 'Berhasil menambahkan File.',
                        'fileName' => $fileName,
                        'statusCode' => 200
                    ];
                } else {
                    $res = [
                        'status'  => 0,
                        'message' => 'Gagal menambahkan File',
                        'statusCode' => 400
                    ];
                }

                return $res;
            });
        } else {
            $messages = $validator->errors()->all('<li>:message</li>');
            $res = [
                'status'  => 2,
                'message' => '<ul class="m--marginless">' . implode('', $messages) . '</ul>',
                'statusCode' => 400
            ];
        }

        return response($res, $res['statusCode']);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @param null $type
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function imageDelete(Request $request, $id, $type = null)
    {
        if($type == 'edit') {
            $usulan = $request->input('usulan');
            switch ($usulan) {
                case 'penjualan':
                    $image = PenjualanFoto::findOrFail($id);
                    $oldImage = $image->foto;
                    $location = PenjualanFoto::imageLocation($image->id_penjualan, $oldImage);
                    break;
                case 'sewa':
                    $image = SewaFoto::findOrFail($id);
                    $oldImage = $image->foto;
                    $location = SewaFoto::imageLocation($image->id_sewa, $oldImage);
                    break;
                case 'bongkaran':
                    $image = BongkaranFoto::findOrFail($id);
                    $oldImage = $image->foto;
                    $location = BongkaranFoto::imageLocation($image->id_bongkaran, $oldImage);
                    break;
                case 'pengadaan-penawaran':
                    $image = PengadaanPenawaranFoto::findOrFail($id);
                    $oldImage = $image->foto;
                    $location = PengadaanPenawaranFoto::imageLocation($image->id_pengadaan_penawaran, $oldImage);
                    break;
                case 'pengadaan-renovasi':
                    $image = PengadaanRenovasiFoto::findOrFail($id);
                    $oldImage = $image->foto;
                    $location = PengadaanRenovasiFoto::imageLocation($image->id_pengadaan_renovasi, $oldImage);
                    break;
            }

            if(file_exists($location)){
                unlink($location);
            }
        } else {
            $image = ImageTmp::findOrFail($id);
            $oldImage = $image->file;
            $location = ImageTmp::imageLocation() . '/' . $oldImage;
            if(file_exists($location)) {
                unlink($location);
            }
        }

        if($image->delete()) {
            $status = 1;
        } else {
            $status = 0;
        }

        return response(['status' => $status]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $id
     * @param null $type
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     * @throws \Exception
     */
    public function fileDelete(Request $request, $id, $type = null)
    {
        if($type == 'edit') {
            $usulan = $request->input('usulan');
            switch ($usulan) {
                case 'pengadaan-pembangunan':
                    $file = PengadaanPembangunanGambar::findOrFail($id);
                    $oldImage = $file->file;
                    $location = PengadaanPembangunanGambar::imageLocation($file->id_pengadaan_pembangunan, $oldImage);
                    break;
                case 'pengadaan-renovasi-rencana':
                case 'pengadaan-renovasi-eksisting':
                    $file = PengadaanRenovasiGambar::findOrFail($id);
                    $oldImage = $file->file;
                    $location = PengadaanRenovasiGambar::imageLocation($file->id_pengadaan_renovasi, $oldImage);
                    break;
            }

            if(file_exists($location)){
                unlink($location);
            }
        } else {
            $file = FileTmp::findOrFail($id);
            $oldImage = $file->file;
            $location = FileTmp::location() . '/' . $oldImage;
            if(file_exists($location)) {
                unlink($location);
            }
        }

        if($file->delete()) {
            $status = 1;
        } else {
            $status = 0;
        }

        return response(['status' => $status]);
    }

    /**
     * @param $param
     * @param $clean
     * @return array
     */
    public function cleanNumber($param, $clean)
    {
        $param = collect($param);
        $param = $param->transform(function ($item, $key) use ($clean) {
            if (in_array($key, $clean)) {
                if (is_array($item)) {
                    $item = collect($item);
                    $item = $item->transform(function ($i, $k) {
                        $i = str_replace(['.', ','], ['', '.'], $i);
                        return $i;
                    })->toArray();
                } else {
                    $item = str_replace(['.', ','], ['', '.'], $item);
                }
            }

            return $item;
        });

        return $param->toArray();
    }
}
