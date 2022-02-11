<?php

namespace App\Http\Controllers\Admin\Master;

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
use App\Model\Asset\AssetTetapLainnya;
use App\Repositories\Permission\Permission;
use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ZanySoft\Zip\Zip;

class ImportController extends Controller
{

    private $route = 'admin.master.import';
    private $config, $layout;
    private $title = 'Import';
    private $permission = 'master-import';

    public function __construct()
    {
        $this->layout = $this->route;
        $this->config = [
            'route'     => $this->route,
            'title'     => $this->title,
            'pageTitle' => $this->title,
            'permission'=> $this->permission
        ];
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        Permission::access('view-' . $this->permission);

        $data['config'] = $this->config;
        return view($this->layout . '.create', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function store(Request $request)
    {
        Permission::access('create-' . $this->permission);

        $validate = [
            'file'     => 'file'
        ];

        $validator = Validator::make($request->all(), $validate);
        if (!$validator->fails()) {
            if($request->hasFile('file')) {
                $folder = 'app/tmp/file_' . time();
                $zip = Zip::open($request->file('file'));
                if(!file_exists(storage_path($folder))){
                    mkdir(storage_path($folder), 0755, true);
                }
                $zip->extract(storage_path($folder));

                $files = ['MA_ALAT_ANGKUTAN', 'MA_ALAT_BERAT', 'MA_ASET_BANGUNAN_AIR', 'MA_ASET_GEDUNG_BANGUNAN',
                    'MA_ASET_INSTALASI', 'MA_ASET_JALAN_JEMBATAN', 'MA_ASET_KDP', 'MA_ASET_PERSEDIAAN', 'MA_ASET_PM_KHUSUS_TIK',
                    'MA_ASET_PM_NON_TIK', 'MA_ASET_RENOVASI', 'MA_ASET_RUMAH_NEGARA', 'MA_ASET_TAK_BERWUJUD', 'MA_ASET_TANAH','MA_ASET_TETAP_LAINNYA'];

                foreach ($files as $row){
                    if(file_exists(storage_path($folder . '/' . $row . '.csv'))){
                        $this->import($row, storage_path($folder . '/' . $row . '.csv'));
                    }
                }
            }

            if (true) {
                $res = [
                    'status'  => 1,
                    'message' => 'Berhasil Mengimport Data'
                ];
            } else {
                $res = [
                    'status'  => 0,
                    'message' => 'Gagal menambahkan data ' . $this->title
                ];
            }
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
     * @param $slug
     * @return \Illuminate\Http\JsonResponse
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     */
    private function import($slug ,$file)
    {
        Permission::access('import-asset-' . $slug);

        $opt = [];
        switch ($slug) {
            case 'MA_ALAT_ANGKUTAN':
                $opt = [
                    'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'NO_BPKB', 'NO_POLISI', 'PEMAKAI', 'STATUS_PENGGUNAAN', 'TGL_PENARIKAN_DATA'],
                    'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib', 'tgl_perolehan', null, 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto', 'jumlah_kib', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'no_bpkb', 'no_polisi', 'pemakai', 'status_penggunaan', null],
                    'model'   => new AssetAlatBermotor()
                ];
                break;
            case 'tanah':
                $opt = [
                    'valid' => ["No", "Kode Barang", "NUP", "Kode Satker", "Nama Satker", "KIB", "Nama Barang", "Kondisi", "Jenis Dokumen", "Kepemilikan ", "Jenis Sertifikat", "Merk/Tipe", "Tgl Perolehan", "Nilai Perolehan Pertama", "Nilai Mutasi", "Nilai Perolehan", "Nilai Penyusutan", "Nilai Buku", "Kuantitas(m2)", "Luas Tanah Seluruhnya", "Luas Tanah Untuk Bangunan", "Luas tanah Untuk Sarana Lingkungan", "Luas Lahan Kosong", "Jml Foto", "Status Penggunaan", "Status Pengelolaan", "No. PSP", "Tgl PSP", "Alamat", "RT/RW", "Kelurahan/Desa", "Kecamatan", "Kota/Kabupaten", "Kode Kab/Kota", "Provinsi", "Kode Provinsi", "Kode Pos", "Alamat Lainnya", "Jumlah KIB", "SBSK", "Optimalisasi"],
                    'convert' => [null, 'kode_barang','nup', 'kode_satker','nama_satker','kib','nama_barang', 'kondisi','jenis_dokumen','kepemilikan','jenis_sertifikat','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitasi','luas_tanah_seluruhnya','luas_tanah_untuk_bangunan','luas_tanah_untuk_sarana','luas_lahan_kosong','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','alamat','rt','kelurahan','kecamatan','kabupaten','kode_kabupaten','provinsi','kode_provinsi','kode_pos','alamat_lainnya','jml_kib','sbsk','optimalisasi'],
                    'model' => new AssetTanah()
                ];
                break;
            case 'peralatannontik':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP','Jumlah KIB'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jumlah_kib'],
                    'model' => new AssetPeralatanNonTik()
                ];
                break;
            case 'peralatantik':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'],
                    'model' => new AssetPeralatanKhususTik()
                ];
                break;
            case 'alatberat':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP','Jumlah KIB'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp', 'jumlah_kib'],
                    'model' => new AssetAlatBerat()
                ];
                break;
            case 'bangunangedung':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Dokumen','Kepemilikan','Jenis Sertifikat','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Luas Bangunan','Luas Dasar Bangunan','Jumlah Lantai','Jml Foto','Jalan','Kode Kab/Kota','Uraian Kota/Kabupaten','Kode Provinsi','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP','Jmlh KIB','Kode Pos','SBSK','Optimalisasi'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','dokumen','kepemilikan','jenis_sertifikat','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','luas_bangunan','luas_dasar_bangunan','jumlah_lantai','jml_foto','jalan','kode_kab','uraian_kabupaten','kode_provinsi','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jml_kib','kode_pos','sbsk','optimalisasi'],
                    'model' => new AssetBangunanGedung()
                ];
                break;
            case 'rumahnegara':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Jenis Dokumen','Kepemilikan','Jenis sertifikat','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Luas Bangunan','Luas Dasar Bangunan','Alamat','Jalan','Kode Kota/Kab','Uraian Kota/Kabupaten','Kode Provinsi','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP','Jumlah KIB','SBSK','Optimalisasi'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','jenis_dokumen','kepemilikan','jenis_sertifikat','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','luas_bangunan','luas_dasar_bangunan','alamat','jalan','kode_kab','uraian_kabupaten','kode_provinsi','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jumlah_kib','sbsk','optimalisasi'],
                    'model' => new AssetRumahNegara()
                ];
                break;
            case 'jalanjembatan':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Luas Bangunan','Luas Dasar','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP'],
                    'convert' => [null,'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','luas_bangunan','luas_dasar','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'],
                    'model' => new AssetJalanJembatan()
                ];
                break;
            case 'airirigasi':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Luas Bangunan','Luas Dasar','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP','Jmlh KIB'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','luas_bangunan','luas_dasar','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','jml_kib'],
                    'model' => new AssetAirIrigasi()
                ];
                break;
            case 'instalasijaringan':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'],
                    'model' => new AssetInstalasiJaringan()
                ];
                break;
            case 'tetaplainnya':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'],
                    'model' => new AssetTetapLainnya()
                ];
                break;
            case 'takberwujud':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'],
                    'model' => new AssetTakBerwujud()
                ];
                break;
            case 'renovasi':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Status Penggunaan','Status Pengelolaan','Jml Foto','Kode KPKNL'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','status_penggunaan','status_pengelolaan','jml_foto','kode_kpknl'],
                    'model' => new AssetRenovasi()
                ];
                break;
            case 'konstruksi':
                $opt = [
                    'valid' => ['No','Kode Barang','NUP','Kode Satker','Nama Satker','KIB','Nama Barang','Kondisi','Merk/Tipe','Tgl Perolehan','Nilai Perolehan Pertama','Nilai Mutasi','Nilai Perolehan','Nilai Penyusutan','Nilai Buku','Kuantitas','Jml Foto','Status Penggunaan','Status Pengelolaan','No PSP','Tgl PSP'],
                    'convert' => [null, 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_penyusutan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'],
                    'model' => new AssetKonstruksiDalamPengerjaan()
                ];
                break;
        }

        $res = $this->importData($file, $opt);

        return response()->json($res);
    }

    /**
     * @param $file
     * @param $opt
     * @return array
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Common\Exception\UnsupportedTypeException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    private function importData($file, $opt)
    {
        $jmlHead = count($opt['valid']);
        $model = $opt['model'];
        $convertHeader = $opt['convert'];
        $validHeader = $opt['valid'];

        $reader = ReaderFactory::create(Type::CSV);
        $reader->open($file);

        $i = 0;
        $datas = [];
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $tmp = explode(';', $row[0]);

                if ($i == 0) {
                    if (count($tmp) != $jmlHead) {
                        $res = [
                            'status'  => 0,
                            'message' => 'Jumlah Header Tidak Cocok'
                        ];
                        return response()->json($res);
                    } else {
                        foreach ($tmp as $k => $val) {
                            if ($val != $validHeader[$k]) {
                                $res = [
                                    'status'  => 0,
                                    'message' => 'Header Tidak Cocok'
                                ];
                                return response()->json($res);
                            }
                        }
                    }
                } else {
                    $data = [];

                    if(count($tmp) > count($convertHeader)){
                    }

                    foreach ($tmp as $k => $val) {
                        if($k != 0) {
                            $data[$convertHeader[$k]] = $val != '' ? $val : null;
                        }
                    }

                    $datas[] = $data;
                }

                $i++;
            }
        }

        $reader->close();

        DB::transaction(function () use ($datas, $model) {
            $model->truncate();

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
