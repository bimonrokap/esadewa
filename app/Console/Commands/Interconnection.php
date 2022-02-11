<?php

namespace App\Console\Commands;

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
use App\Model\InterconnectionConfig;
use App\Model\MappingAsset;
use App\Model\MonitoringPsp;
use Carbon\Carbon;
use Illuminate\Console\Command;
use GuzzleHttp\Client;

class Interconnection extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interconnection:siman {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Interkoneksi data dengan DJKN';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $table = $this->argument('table');

        $client = new Client([
            'base_uri' => 'https://103.93.189.79:8243/',
            'verify' => false
        ]);


        $response = $client->request('POST', 'token',
            [
                'form_params' => [
                    'grant_type' => 'password',
                    'username' => 'userma',
                    'password' => 'maP@ss',
                ],
                'headers' => [
                    'Authorization' => 'Basic eXg2czZGaDZ2Y0dmOE9pYVVCRkNIZjhFN1pZYTpnTDN2OE1qWDE0RDNQbG9BeWRsWU10Z25ONjhh'
                ]
            ]
        )->getBody()->getContents();

        $json = json_decode($response);
        $accessToken = $json->access_token;

        $response = $client->request('GET', 'apiMA/v1.0.0/GetMA_RCOUNT',
            [
                'headers' => [
                    'accept' => "application/json",
                    'Authorization' => "Bearer {$accessToken}"
                ]
            ]
        );

        $statusCode = $response->getStatusCode();

        $now = Carbon::now();
        $interConfig = InterconnectionConfig::get()->pluck('value', 'name')->toArray();
        $nextCheck = Carbon::parse($interConfig['next_check']);

        if($statusCode == 200) {
            if($nextCheck->isNextWeek() == false) {
                InterconnectionConfig::where('name', 'next_check')->update([
                    'value' => $now->copy()->addWeek()->startOfWeek()->addMinute(10)->toDateTimeString()
                ]);
            }
        } else {
            if($nextCheck->isNextWeek() == false) {
                if($nextCheck->isMonday()) {
                    InterconnectionConfig::where('name', 'next_check')->update([
                        'value' => $now->copy()->addDay()->addMinute(10)->toDateTimeString()
                    ]);
                } else {
                    InterconnectionConfig::where('name', 'next_check')->update([
                        'value' => $now->copy()->addWeek()->startOfWeek()->addMinute(10)->toDateTimeString()
                    ]);
                }
            }
        }

        InterconnectionConfig::where('name', 'last_check')->update([
            'value' => $now->toDateTimeString(),
        ]);
        InterconnectionConfig::where('name', 'last_status')->update([
            'value' => $statusCode,
        ]);

        if($statusCode == 200) {

            $response = $response->getBody()->getContents();

            $count = json_decode($response)->Data->MA_RCOUNT;
            $limit = 10000;
            foreach ($count as $data) {
                if($table != null && $data->TABEL != $table) {
                    continue;
                }

                $tanggal = Carbon::parse($data->TANGGAL)->toDateTimeString();
                InterconnectionConfig::where('name', 'last_update')->update([
                    'value' => $tanggal,
                ]);

                $interconnection = \App\Model\Interconnection::where('table', $data->TABEL)->where('date', $tanggal)->first();
                if($interconnection == null || $interconnection->status == 0) {
                    $idCategory = 0;
                    switch ($data->TABEL) {
                        case "MA_ASET_TANAH":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',     'tgl_perolehan',        'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitasi',   'kode_provinsi', 'provinsi',        'kode_kabupaten',   'kabupaten',        'kecamatan', 'kelurahan',       'kode_pos', 'rt',       'alamat', 'alamat_lainnya', 'luas_tanah_seluruhnya', 'luas_tanah_untuk_bangunan', 'luas_tanah_untuk_sarana',        'luas_lahan_kosong', 'sbsk', 'optimalisasi', 'no_psp', 'tgl_psp', 'jml_foto',       'jml_kib',      'jenis_sertifikat', 'kepemilikan', 'jenis_dokumen', 'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB',  'TANGGAL_PEROLEHAN',    'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS',    'KODE_PROVINSI', 'URAIAN_PROVINSI', 'KODE_KAB_KOTA',    'URAIAN_KAB_KOTA',  'KECAMATAN', 'KELURAHAN_DESA',  'KODE_POS', 'RT_RW',    'ALAMAT', 'ALAMAT_LAINNYA', 'LUAS_TANAH_SELURUHNYA', 'LUAS_TANAH_UNTUK_BANGUNAN', 'LUAS_TANAH_SARANA_LINGKUNGAN',   'LUAS_TANAH_KOSONG', 'SBSK', 'OPTIMALISASI', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO',    'JUMLAH_KIB',   'JENIS_SERTIFIKAT', 'KEPEMILIKAN', 'JENIS_DOKUMEN', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetTanah();
                            $idCategory = 3;
                            break;
                        case "MA_ASET_TAK_BERWUJUD":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'no_psp', 'tgl_psp', 'jml_foto',    'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetTakBerwujud();
                            $idCategory = 15;
                            break;
                        case "MA_ASET_RUMAH_NEGARA":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'kode_kab',      'uraian_kabupaten','kode_provinsi', 'alamat', 'luas_bangunan', 'luas_dasar_bangunan', 'sbsk', 'optimalisasi', 'no_psp', 'tgl_psp', 'jml_foto',    'jumlah_kib', 'jenis_sertifikat', 'kepemilikan', 'jenis_dokumen', 'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'KODE_KAB_KOTA', 'URAIAN_KAB_KOTA', 'KODE_PROVINSI', 'ALAMAT', 'LUAS_BANGUNAN', 'LUAS_DASAR_BANGUNAN', 'SBSK', 'OPTIMALISASI', 'NO_SK_PSP', 'TGL_SK_PSP', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'JENIS_SERTIFIKAT', 'KEPEMILIKAN', 'JENIS_DOKUMEN', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN']
                            ];
                            $model = new AssetRumahNegara();
                            $idCategory = 10;
                            break;
                        case "MA_ASET_RENOVASI":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetRenovasi();
                            $idCategory = 16;
                            break;
                        case "MA_ASET_KDP":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'tgl_perolehan',     'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'no_psp', 'tgl_psp', 'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'TANGGAL_PEROLEHAN', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetKonstruksiDalamPengerjaan();
                            $idCategory = 17;
                            break;
                        case "MA_ASET_JALAN_JEMBATAN":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'luas_dasar', 'luas_bangunan', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'LUAS_DASAR', 'LUAS_BANGUNAN', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetJalanJembatan();
                            $idCategory = 11;
                            break;
                        case "MA_ASET_INSTALASI_JARINGAN":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jalan', 'jml_foto', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JALAN', 'JUMLAH_FOTO', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetInstalasiJaringan();
                            $idCategory = 13;
                            break;
                        case "MA_ASET_GEDUNG_BANGUNAN":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'sbsk', 'optimalisasi', 'kode_kab',      'uraian_kabupaten','kode_provinsi', 'kode_pos', 'jalan', 'luas_bangunan', 'luas_dasar_bangunan', 'jumlah_lantai', 'no_psp', 'tgl_psp', 'jml_foto',    'jml_kib',    'status_pengelolaan', 'jenis_sertifikat', 'kepemilikan', 'dokumen', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'SBSK', 'OPTIMALISASI', 'KODE_KAB_KOTA', 'URAIAN_KAB_KOTA', 'KODE_PROVINSI', 'KODE_POS', 'JALAN', 'LUAS_BANGUNAN', 'LUAS_DASAR_BANGUNAN', 'JUMLAH_LANTAI', 'NO_SK_PSP', 'TGL_SK_PSP', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'STATUS_PENGELOLAAN', 'JENIS_SERTIFIKAT', 'KEPEMILIKAN', 'DOKUMEN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetBangunanGedung();
                            $idCategory = 9;
                            break;
                        case "MA_ASET_BANGUNAN_AIR":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'luas_dasar', 'luas_bangunan', 'jalan', 'no_psp', 'tgl_psp', 'jml_foto',    'jml_kib',    'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'LUAS_DASAR', 'LUAS_BANGUNAN', 'JALAN', 'NO_PSP', 'TGL_PSP', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetAirIrigasi();
                            $idCategory = 12;
                            break;
                        case "MA_ASET_ALAT_BERAT":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'no_psp', 'tgl_psp', 'jumlah_kib', 'jml_foto',    'status_pengelolaan', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'NO_PSP', 'TGL_PSP', 'JUMLAH_KIB', 'JUMLAH_FOTO', 'STATUS_PENGELOLAAN', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetAlatBerat();
                            $idCategory = 7;
                            break;
                        case "MA_ASET_ALAT_ANGKUTAN":
                            $opt = [
                                'convert' => ['kode_satker', 'nama_satker', 'kode_barang', 'nama_barang', 'nup', 'kib',    'tgl_perolehan',     'tgl_rekam_pertama', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kondisi', 'merk', 'kuantitas', 'jml_foto',    'jumlah_kib', 'no_psp', 'tgl_psp', 'status_pengelolaan', 'no_bpkb', 'no_polisi', 'pemakai', 'status_penggunaan'],
                                'valid'   => ['KODE_SATKER', 'NAMA_SATKER', 'KODE_BARANG', 'NAMA_BARANG', 'NUP', 'NO_KIB', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KONDISI', 'MERK', 'KUANTITAS', 'JUMLAH_FOTO', 'JUMLAH_KIB', 'NO_PSP', 'TGL_PSP', 'STATUS_PENGELOLAAN', 'NO_BPKB', 'NO_POLISI', 'PEMAKAI', 'STATUS_PENGGUNAAN'],
                            ];
                            $model = new AssetAlatBermotor();
                            $idCategory = 4;
                            break;
                        case "MA_ASET_PM_NON_TIK":
                            $opt = [
                                'convert' => ['kode_barang', 'nup', 'kode_satker', 'nama_satker', 'nama_barang', 'kondisi', 'merk', 'tgl_perolehan', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kuantitas', 'jml_foto', 'status_penggunaan', 'status_pengelolaan', 'no_psp', 'tgl_psp', 'jumlah_kib'],
                                'valid'   => ['KODE_BARANG', 'NUP', 'KODE_SATKER', 'NAMA_SATKER', 'NAMA_BARANG', 'KONDISI', 'MERK', 'TANGGAL_PEROLEHAN', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KUANTITAS', 'JUMLAH_FOTO', 'STATUS_PENGGUNAAN', 'STATUS_PENGELOLAAN', 'NO_PSP', 'TGL_PSP', 'JUMLAH_KIB'],
                            ];
                            $model = new AssetPeralatanNonTik();
                            $idCategory = 5;
                            break;
                        case "MA_ASET_PM_KHUSUS_TIK":
                            $opt = [
                                'convert' => ['kode_barang', 'nup', 'kode_satker', 'nama_satker', 'nama_barang', 'kondisi', 'merk', 'tgl_perolehan', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kuantitas', 'jml_foto', 'status_penggunaan', 'status_pengelolaan', 'no_psp', 'tgl_psp'],
                                'valid'   => ['KODE_BARANG', 'NUP', 'KODE_SATKER', 'NAMA_SATKER', 'NAMA_BARANG', 'KONDISI', 'MERK', 'TANGGAL_PEROLEHAN', 'NILAI_PEROLEHAN_PERTAMA', 'NILAI_MUTASI', 'NILAI_PEROLEHAN', 'NILAI_PENYUSUTAN', 'NILAI_BUKU', 'KUANTITAS', 'JUMLAH_FOTO', 'STATUS_PENGGUNAAN', 'STATUS_PENGELOLAAN', 'NO_PSP', 'TGL_PSP'],
                            ];
                            $model = new AssetPeralatanKhususTik();
                            $idCategory = 6;
                            break;
                        case "MA_ASET_TETAP_LAINNYA":
                            $opt = [
                                'convert' => [ 'kode_barang', 'nup', 'kode_satker', 'nama_satker', 'kib', 'nama_barang', 'kondisi', 'merk', 'tgl_perolehan', 'nilai_perolehan_pertama', 'nilai_mutasi', 'nilai_perolehan', 'nilai_penyusutan', 'nilai_buku', 'kuantitas', 'jml_foto', 'status_penggunaan', 'status_pengelolaan', 'no_psp', 'tgl_psp', 'tgl_rekam_pertama' ],
                                'valid' =>  [ "KODE_BARANG", "NUP", "KODE_SATKER", "NAMA_SATKER", "NO_KIB", "NAMA_BARANG", "KONDISI", "MERK", "TANGGAL_PEROLEHAN", "NILAI_PEROLEHAN_PERTAMA", "NILAI_MUTASI", "NILAI_PEROLEHAN", "NILAI_PENYUSUTAN", "NILAI_BUKU", "KUANTITAS", "JUMLAH_FOTO", "STATUS_PENGGUNAAN", "STATUS_PENGELOLAAN", "NO_PSP", "TGL_PSP", "TGL_REKAM_PERTAMA" ]
                            ];
                            $model = new AssetTetapLainnya();
                            $idCategory = 14;
                            break;
                            default:
                            $opt = [];
                            $model = '';
                    }

                    if($model != '') {
                        $tmpModel = $model;

                        if($interconnection == null) {
                            \DB::table($tmpModel->getTable())->delete();
                            MappingAsset::where('id_category_asset', $idCategory)->delete();

                            $interconnection = \App\Model\Interconnection::create([
                                'table' => $data->TABEL,
                                'count' => $data->ROWCOUNT,
                                'date' => $tanggal,
                                'status' => 0,
                                'count_real' => 0
                            ]);
                        }

                        $startData = $interconnection->count_real;
                        if($interconnection->count > $limit) {
                            $jmlData = ceil(($interconnection->count - $startData) / $limit);
                        } else {
                            $jmlData = 1;
                        }

                        for ($i = 0; $i < $jmlData; $i++) {
                            $start = ($i * $limit) + 1 + $startData;
                            if($i == $jmlData - 1) {
                                $end = $interconnection->count;
                            } else {
                                $end = ($i * $limit) + $limit + $startData;
                            }

                            $res = $client->request('GET', 'apiMA/v1.0.0/Get'.$interconnection->table.'?param1='.$start.'&param2='.$end,
                                [
                                    'headers' => [
                                        'accept' => "application/json",
                                        'Authorization' => "Bearer {$accessToken}"
                                    ]
                                ]
                            )->getBody()->getContents();
                            $lists = json_decode($res);

                            foreach ($lists->Data->{$data->TABEL} as $list) {
                                $row = ['tanggal_update' => $tanggal];
                                foreach ($list as $k => $l) {
                                    if(in_array($k, $opt['valid'])) {
                                        if(in_array($k, ['TGL_PSP', 'TANGGAL_PEROLEHAN', 'TGL_REKAM_PERTAMA'])) {
                                            if($l != null) {
                                                $val = Carbon::parse($l)->toDateTimeString();
                                            } else {
                                                $val = null;
                                            }
                                        } else {
                                            $val = $l;
                                        }
                                        $row[$opt["convert"][array_search($k, $opt['valid'])]] = $val;
                                    }
                                }

                                $tmpModel = $tmpModel->create($row);
                                $interconnection->count_real = $interconnection->count_real + 1;
                                $interconnection->save();

                                MappingAsset::create([
                                    'id_category_asset' => $idCategory,
                                    'mapping_asset'     => $tmpModel->kode_satker . '-' . $tmpModel->kode_barang . '-' . $tmpModel->nup,
                                    'id_benda'          => $tmpModel->id
                                ]);

                                echo "Data Asset ".$data->TABEL." : ".$interconnection->count_real." dari ".$interconnection->count."\n";
                            }

                        }

                        if(!in_array($data->TABEL, ['MA_ASET_RENOVASI'])) {
                            $mappingPsp = $model->select(['kode_satker',
                                                          \DB::raw('sum(nilai_perolehan) as nilai_perolehan'),
                                                          \DB::raw('count(*) as unit'),
                                                          \DB::raw('sum(IF(no_psp IS NULL,0,nilai_perolehan)) as nilai_perolehan_psp'),
                                                          \DB::raw('sum(IF(no_psp IS NULL,0,1)) as unit_psp')
                            ])->groupBy('kode_satker')->get();

                            foreach($mappingPsp as $map) {
                                MonitoringPsp::where('kode_satker', $map->kode_satker)->where('id_category_asset', $idCategory)->delete();

                                MonitoringPsp::create([
                                    'kode_satker' => $map->kode_satker,
                                    'id_category_asset' => $idCategory,
                                    'total_unit' => $map->unit,
                                    'total_nilai' => $map->nilai_perolehan,
                                    'total_unit_psp' => $map->unit_psp,
                                    'total_nilai_psp' => $map->nilai_perolehan_psp,
                                    'total_unit_belum_psp' => $map->unit - $map->unit_psp,
                                    'total_nilai_belum_psp' => $map->nilai_perolehan - $map->nilai_perolehan_psp
                                ]);
                            }
                        }

                        $interconnection->status = 1;
                        $interconnection->save();
                    }
                }
            }
        }

    }


}
