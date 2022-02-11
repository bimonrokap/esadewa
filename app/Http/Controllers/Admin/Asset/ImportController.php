<?php

namespace App\Http\Controllers\Admin\Asset;

use App\Http\Controllers\Controller;
use App\Model\Asset\AssetAirIrigasi;
use App\Model\Asset\AssetAlatBerat;
use App\Model\Asset\AssetAlatBermotor;
use App\Model\Asset\AssetBangunanGedung;
use App\Model\Asset\AssetInstalasiJaringan;
use App\Model\Asset\AssetJalanJembatan;
use App\Model\Asset\AssetKonstruksiDalamPengerjaan;
use App\Model\Asset\AssetPeralatanKhususTik;
use App\Model\Asset\AssetPeralatanNonTik;
use App\Model\Asset\AssetRenovasi;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetTakBerwujud;
use App\Model\Asset\AssetTanah;
use App\Model\UploadAsset;
use App\Repositories\Permission\Permission;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ImportController extends Controller
{

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    public function import(Request $request, $slug)
    {
//        Permission::access('import-asset-' . $slug);
        Permission::access('import-asset');

        switch ($slug) {
            // DONE
            case 'tanah':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB',  'TANGGAL_PEROLEHAN',    'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS',    'KODE_PROVINSI', 'URAIAN_PROVINSI', 'KODE_KAB_KOTA',    'URAIAN_KAB_KOTA',  'KECAMATAN', 'KELURAHAN_DESA',  'KODE_POS', 'RT_RW',    'ALAMAT', 'ALAMAT_LAINNYA', 'LUAS_TANAH_SELURUHNYA', 'LUAS_TANAH_UNTUK_BANGUNAN', 'LUAS_TANAH_SARANA_LINGKUNGAN',   'LUAS_TANAH_KOSONG', 'SBSK', 'OPTIMALISASI', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO',    'JUMLAH_KIB',   'JENIS_SERTIFIKAT', 'KEPEMILIKAN', 'JENIS_DOKUMEN', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',     'tgl_perolehan',        'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitasi',   'kode_provinsi', 'provinsi',        'kode_kabupaten',   'kabupaten',        'kecamatan', 'kelurahan',       'kode_pos', 'rt',       'alamat', 'alamat_lainnya', 'luas_tanah_seluruhnya', 'luas_tanah_untuk_bangunan', 'luas_tanah_untuk_sarana',        'luas_lahan_kosong', 'sbsk', 'optimalisasi', 'no_psp', 'tgl_psp', 'jml_foto',       'jml_kib',      'jenis_sertifikat', 'kepemilikan', 'jenis_dokumen', 'status_pengelolaan', 'status_penggunaan', 'tanggal_update',     NULL],
                    'model'   => new AssetTanah()
                ];

                break;
            case 'bermotor':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'NO_BPKB', 'NO_POLISI', 'PEMAKAI', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'jumlah_kib', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'no_bpkb', 'no_polisi', 'pemakai', 'status_penggunaan', 'tanggal_update',     null],
                    'model'   => new AssetAlatBermotor()
                ];
                break;
            case 'alatberat':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'NO_PSP', 'TGL_PSP', 'JUMLAH_KIB', 'JUMLAH_FOTO', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'no_psp', 'tgl_psp', 'jumlah_kib', 'jml_foto',    'status_pengelolaan', 'status_penggunaan', 'tanggal_update',     null],
                    'model'   => new AssetAlatBerat()
                ];
                break;
            case 'bangunangedung':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'SBSK', 'OPTIMALISASI', 'KODE_KAB_KOTA', 'URAIAN_KAB_KOTA', 'KODE_PROVINSI', 'KODE_POS', 'JALAN', 'LUAS_BANGUNAN', 'LUAS_DASAR_BANGUNAN', 'JUMLAH_LANTAI', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'STATUS_PENGELOLAAN', 'JENIS_SERTIFIKAT', 'KEPEMILIKAN', 'DOKUMEN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'sbsk', 'optimalisasi', 'kode_kab',      'uraian_kabupaten','kode_provinsi', 'kode_pos', 'jalan', 'luas_bangunan', 'luas_dasar_bangunan', 'jumlah_lantai', 'no_psp', 'tgl_psp', 'jml_foto',    'jml_kib',    'status_pengelolaan', 'jenis_sertifikat', 'kepemilikan', 'dokumen', 'status_penggunaan', 'tanggal_update',     null],
                    'model'   => new AssetBangunanGedung()
                ];
                break;
            case 'rumahnegara':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'KODE_KAB_KOTA', 'URAIAN_KAB_KOTA', 'KODE_PROVINSI', 'ALAMAT', 'LUAS_BANGUNAN', 'LUAS_DASAR_BANGUNAN', 'SBSK', 'OPTIMALISASI', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'JENIS_SERTIFIKAT', 'KEPEMILIKAN', 'JENIS_DOKUMEN', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'kode_kab',      'uraian_kabupaten','kode_provinsi', 'alamat', 'luas_bangunan', 'luas_dasar_bangunan', 'sbsk', 'optimalisasi', 'no_psp', 'tgl_psp', 'jml_foto',    'jumlah_kib', 'jenis_sertifikat', 'kepemilikan', 'jenis_dokumen', 'status_pengelolaan', 'status_penggunaan',   'tanggal_update',   null],
                    'model'   => new AssetRumahNegara()
                ];
                break;
            case 'jalanjembatan':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'LUAS_DASAR', 'LUAS_BANGUNAN', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'luas_dasar', 'luas_bangunan', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'status_penggunaan',  'tanggal_update',    null],
                    'model'   => new AssetJalanJembatan()
                ];
                break;
            case 'airirigasi':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'LUAS_DASAR', 'LUAS_BANGUNAN', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'luas_dasar', 'luas_bangunan', 'no_psp', 'tgl_psp', 'jml_foto',    'jml_kib',    'status_pengelolaan', 'status_penggunaan', 'tanggal_update',      null],
                    'model'   => new AssetAirIrigasi()
                ];
                break;
            case 'instalasijaringan':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'status_penggunaan',    'tanggal_update',      null],
                    'model'   => new AssetInstalasiJaringan()
                ];
                break;
            case 'takberwujud':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'no_psp', 'tgl_psp', 'jml_foto',    'status_pengelolaan', 'status_penggunaan', 'tanggal_update',     null],
                    'model'   => new AssetTakBerwujud()
                ];
                break;
            case 'renovasi':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'status_pengelolaan', 'status_penggunaan', 'tanggal_update',     null],
                    'model'   => new AssetRenovasi()
                ];
                break;
            case 'konstruksi':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'TANGGAL_PEROLEHAN', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA', 'ID'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'tgl_perolehan',     'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'no_psp', 'tgl_psp', 'status_pengelolaan', 'status_penggunaan', 'tanggal_update',     null],
                    'model'   => new AssetKonstruksiDalamPengerjaan()

                ];
                break;

            // Not DONE Tetap Lainnya, Peralatan Non Tik dan Peralatan Khusus TIK
//            case 'peralatannontik':
//                $opt = [
//                    'valid'   => ['No', 'Kode Barang', 'NUP', 'Kode Satker', 'Nama Satker', 'Nama Barang', 'Kondisi', 'Merk/Tipe', 'Tgl Perolehan', 'Nilai Perolehan Pertama', 'Nilai Mutasi', 'Nilai Perolehan', 'Nilai Penyusutan', 'Nilai Buku', 'Kuantitas', 'Jml Foto', 'Status Penggunaan', 'Status Pengelolaan', 'No PSP', 'Tgl PSP', 'Jumlah KIB'],
//                    'convert' => [null, 'kode_barang', 'nup', 'kode_satker', 'nama_satker', 'nama_barang', 'kondisi', 'merk', 'tgl_perolehan', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kuantitas', 'jml_foto', 'status_penggunaan', 'status_pengelolaan', 'no_psp', 'tgl_psp', 'jumlah_kib'],
//                    'model'   => new AssetPeralatanNonTik()
//                ];
//                break;
//            case 'peralatantik':
//                $opt = [
//                    'valid'   => ['No', 'Kode Barang', 'NUP', 'Kode Satker', 'Nama Satker', 'Nama Barang', 'Kondisi', 'Merk/Tipe', 'Tgl Perolehan', 'Nilai Perolehan Pertama', 'Nilai Mutasi', 'Nilai Perolehan', 'Nilai Penyusutan', 'Nilai Buku', 'Kuantitas', 'Jml Foto', 'Status Penggunaan', 'Status Pengelolaan', 'No PSP', 'Tgl PSP'],
//                    'convert' => [null, 'kode_barang', 'nup', 'kode_satker', 'nama_satker', 'nama_barang', 'kondisi', 'merk', 'tgl_perolehan', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kuantitas', 'jml_foto', 'status_penggunaan', 'status_pengelolaan', 'no_psp', 'tgl_psp'],
//                    'model'   => new AssetPeralatanKhususTik()
//                ];
//                break;
        }

        $validate = [
            'file' => 'required|file'
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            $file = $request->file('file');
            $res = $this->importData($file, $opt, $slug);
        } else {
            $messages = $validator->errors()->all('<li>:message</li>');
            $res = [
                'status'  => 2,
                'message' => '<ul class="m--marginless">' . implode('', $messages) . '</ul>'
            ];
        }

        return response()->json($res);
    }

    /**
     * @param $file
     * @param $opt
     * @param $slug
     * @return array
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    private function importData($file, $opt, $slug)
    {
        $jmlHead = count($opt['valid']);
        $model = $opt['model'];
        $validHeader = $opt['valid'];
        $convertHeader = $opt['convert'];

        $reader = ReaderFactory::create(Type::XLSX);
        $reader->open($file);

        $i = 0;
        $datas = [];
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                if ($i == 0) {
                    if (count($row) != $jmlHead) {
                        $res = [
                            'status'  => 0,
                            'message' => 'Jumlah Header Tidak Cocok'
                        ];
                        return $res;
                    } else {
                        foreach ($row as $k => $val) {
                            if ($val != $validHeader[$k]) {
                                $res = [
                                    'status'  => 0,
                                    'message' => 'Header Tidak Cocok'
                                ];
                                return $res;
                            }
                        }
                    }
                } else {
                    $data = [];
                    if ($row[0] != '') {
                        foreach ($row as $k => $val) {
                            if($convertHeader[$k] != null) {
                                $data[$convertHeader[$k]] = !in_array($val, ['', '-', NULL, 'NULL']) ? $val : null;
                            }
                        }

                        $datas[] = $data;
                    }
                }

                $i++;
            }
        }

        $reader->close();

        DB::transaction(function () use ($datas, $model, $slug, $file) {
            DB::table($model->getTable())->delete();

            $filePath = 'backup_asset/' . $slug;
            $fileName = 'file_' . time() . '.xlsx';
            $file->storeAs($filePath, $fileName);

            UploadAsset::create([
                'object' => $slug,
                'file' => $filePath.'/'.$fileName,
                'date' => $datas[0]['tanggal_update'],
                'created_by' => \Auth::user()->id,
            ]);

            foreach ($datas as $row) {
                $model->create($row);
            }
        });

        if (true) {
            $res = [
                'status'  => 1,
                'message' => 'Berhasil mengimport Data'
            ];
        } else {
            $res = [
                'status'  => 0,
                'message' => 'Gagal menambahkan data ' . $this->title
            ];
        }

        return $res;
    }
}
