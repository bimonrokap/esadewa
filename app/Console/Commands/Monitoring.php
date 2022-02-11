<?php

namespace App\Console\Commands;

use App\Model\Asset\AssetAirIrigasi;
use App\Model\Asset\AssetAlatBerat;
use App\Model\Asset\AssetAlatBermotor;
use App\Model\Asset\AssetBangunanGedung;
use App\Model\Asset\AssetInstalasiJaringan;
use App\Model\Asset\AssetJalanJembatan;
use App\Model\Asset\AssetKonstruksiDalamPengerjaan;
use App\Model\AssetMonitoring;
use App\Model\Asset\AssetPeralatanKhususTik;
use App\Model\Asset\AssetPeralatanNonTik;
use App\Model\Asset\AssetRenovasi;
use App\Model\Asset\AssetRumahNegara;
use App\Model\Asset\AssetTakBerwujud;
use App\Model\Asset\AssetTanah;
use App\Model\Asset\AssetTetapLainnya;
use App\Model\BackupSimak;
use App\Model\Satker;
use App\Model\Wilayah;
use App\Scope\NonDipa;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class Monitoring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monitoring:generate {type?} {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @throws \Exception
     */
    public function handle()
    {

        $type = $this->argument('type');
        if($type == 'satkerRole') {
            $table = $this->argument('table');
            $this->satkerRole($table);
        } else if($type == 'satker') {
            $table = $this->argument('table');

            if($table == 'clean') {
                if(!\Schema::hasTable('satker_bac')) {
                    \DB::statement('CREATE TABLE satker_bac LIKE satkers');
                    \DB::statement('INSERT satker_bac SELECT * FROM satkers');
                }

                $satkers = Satker::withoutGlobalScope(NonDipa::class)->select(\DB::raw('count(*) as jml'), 'kode', 'name')->groupBy('kode')
                    ->orderBy(\DB::raw('count(*)'), 'desc')->get();
                foreach ($satkers as $satker) {
                    if($satker->jml > 0) {
                        $subSatker = Satker::withoutGlobalScope(NonDipa::class)->whereKode($satker->kode)->select('id')->orderBy('id')->get();
                        $idSub = '';
                        $userCount = [];
                        $simakCount = [];
                        foreach ($subSatker as $k => $sub) {
                            if($k == 0){
                                $idSub = $sub->id;
                            }

                            $jmlUser = User::where('id_satker', $sub->id)->count();
                            $jmlSimak = BackupSimak::where('satker_id', $sub->id)->count();

                            if($k != 0 && $jmlUser != 0) {
                                $userCount[] = $sub->id;
                            }

                            if($k != 0 && $jmlSimak != 0) {
                                $simakCount[] = $sub->id;
                            }
                        }

                        if(!empty($userCount)) {
                            User::whereIn('id_satker', $userCount)->update(['id_satker' => $idSub]);
                        }

                        if(!empty($simakCount)) {
                            BackupSimak::whereIn('satker_id', $simakCount)->update(['satker_id' => $idSub]);
                        }

                        Satker::withoutGlobalScope(NonDipa::class)->where('id', '!=', $idSub)->where('kode', $satker->kode)->delete();
                    }
                }

                $tables = ['asset_air_irigasis', 'asset_alat_berats', 'asset_alat_bermotors', 'asset_bangunan_gedungs', 'asset_instalasi_jaringans', 'asset_jalan_jembatans', 'asset_konstruksi_dalam_pengerjaans', 'asset_peralatan_khusus_tiks', 'asset_peralatan_non_tiks', 'asset_persediaans', 'asset_renovasis', 'asset_rumah_negaras', 'asset_tak_berwujuds', 'asset_tanahs', 'asset_tetap_lainnyas'];
            } else {
                if($table != "") {
                    $tables = [$table];
                } else {
                    $tables = ['asset_air_irigasis', 'asset_alat_berats', 'asset_alat_bermotors', 'asset_bangunan_gedungs', 'asset_instalasi_jaringans', 'asset_jalan_jembatans', 'asset_konstruksi_dalam_pengerjaans', 'asset_peralatan_khusus_tiks', 'asset_peralatan_non_tiks', 'asset_persediaans', 'asset_renovasis', 'asset_rumah_negaras', 'asset_tak_berwujuds', 'asset_tanahs', 'asset_tetap_lainnyas'];
                }
            }

            $wilayah = Wilayah::get()->keyBy('code');
            foreach ($tables as $table) {
                $data = DB::table($table)->groupBy('kode_satker')->get();
                $total = 0;
                foreach ($data as $row){
                    $check = Satker::whereKode($row->kode_satker)->withoutGlobalScope(NonDipa::class)->count();
                    if($check == 0) {
                        $idWilayah = substr($row->kode_satker, 5, 4);
                        Satker::create([
                            'kode' => $row->kode_satker,
                            'name' => $row->nama_satker,
                            'id_wilayah' => $wilayah[$idWilayah]->id,
                            'type' => 'general'
                        ]);
                        $total++;
                    }
                }
                echo $table." : $total\n";
            }
            $this->satkerRole(null);
        } else {
            AssetMonitoring::truncate();

            $model = AssetTanah::whereFilled(null)->get();
            $var = [ 'kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','jenis_dokumen','kepemilikan','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_buku','kuantitasi','luas_tanah_seluruhnya','luas_tanah_untuk_bangunan','luas_tanah_untuk_sarana','luas_lahan_kosong','jml_foto','status_penggunaan','no_psp','tgl_psp','alamat','kelurahan','kecamatan','kabupaten','kode_kabupaten','provinsi','kode_provinsi','alamat_lainnya'];
            $data = 'asset_tanahs';
            $name = 'Tanah';
            $this->generate($data, $var, $model, $name);

            $model = AssetRumahNegara::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','jenis_dokumen','tgl_perolehan','nilai_perolehan_pertama','nilai_mutasi','nilai_perolehan','nilai_buku','kuantitas','jml_foto','luas_bangunan','luas_dasar_bangunan','alamat','jalan','kode_kab','uraian_kabupaten','kode_provinsi','status_penggunaan','no_psp','tgl_psp'];
            $data = 'asset_rumah_negaras';
            $name = 'Rumah negara';
            $this->generate($data, $var, $model, $name);

            AssetPeralatanNonTik::whereFilled(null)->chunk(10000, function ($models){
                $var = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
                $data = 'asset_peralatan_non_tiks';
                $name = 'Peralatan Non TIK';
                $this->generate($data, $var, $models, $name);
            });

            AssetPeralatanKhususTik::whereFilled(null)->chunk(10000, function ($models){
                $var = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
                $data = 'asset_peralatan_khusus_tiks';
                $name = 'Peralatan Khusus TIK';
                $this->generate($data, $var, $models, $name);
            });

            $model = AssetJalanJembatan::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','luas_bangunan','luas_dasar','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
            $data = 'asset_jalan_jembatans';
            $name = 'Jalan & Jembatan';
            $this->generate($data, $var, $model, $name);

            $model = AssetInstalasiJaringan::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
            $data = 'asset_instalasi_jaringans';
            $name = 'Instalasi Jaringan';
            $this->generate($data, $var, $model, $name);

            $model = AssetBangunanGedung::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','dokumen','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','luas_bangunan','luas_dasar_bangunan','jumlah_lantai','jml_foto','jalan','kode_kab','uraian_kabupaten','kode_provinsi','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
            $data = 'asset_bangunan_gedungs';
            $name = 'Bangunan Gedung';
            $this->generate($data, $var, $model, $name);

            $model = AssetAirIrigasi::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','luas_bangunan','luas_dasar','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
            $data = 'asset_air_irigasis';
            $name = 'Bangunan Air & Irigasi';
            $this->generate($data, $var, $model, $name);

            AssetTetapLainnya::whereFilled(null)->chunk(10000, function ($models) {
                $var = ['kode_barang', 'nup', 'kode_satker', 'nama_satker', 'kib', 'nama_barang', 'kondisi', 'tgl_perolehan', 'nilai_perolehan_pertama', 'nilai_perolehan', 'nilai_buku', 'kuantitas', 'jml_foto', 'status_penggunaan', 'status_pengelolaan', 'no_psp', 'tgl_psp'];
                $data = 'asset_tetap_lainnyas';
                $name = 'Aset Tetap Lainnya';
                $this->generate($data, $var, $models, $name);
            });

            $model = AssetTakBerwujud::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','status_penggunaan','status_pengelolaan','no_psp','tgl_psp'];
            $data = 'asset_tak_berwujuds';
            $name = 'Aset Tidak Berwujud';
            $this->generate($data, $var, $model, $name);

            $model = AssetRenovasi::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','status_penggunaan','status_pengelolaan','jml_foto','kode_kpknl'];
            $data = 'asset_renovasis';
            $name = 'Aset Renovasi';
            $this->generate($data, $var, $model, $name);

            $model = AssetKonstruksiDalamPengerjaan::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas'];
            $data = 'asset_konstruksi_dalam_pengerjaans';
            $name = 'Konstruksi Dalam Pengerjaan';
            $this->generate($data, $var, $model, $name);

            $model = AssetAlatBerat::whereFilled(null)->get();
            $var = ['kode_barang','nup','kode_satker','nama_satker','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp', 'jumlah_kib'];
            $data = 'asset_alat_berats';
            $name = 'Alat Berat';
            $this->generate($data, $var, $model, $name);

            $model = AssetAlatBermotor::whereFilled(null)->get();
            $var = ['kode_satker','kode_barang','tgl_rekam_pertama','nup','nama_satker','kib','nama_barang','kondisi','merk','tgl_perolehan','nilai_perolehan_pertama','nilai_perolehan','nilai_buku','kuantitas','jml_foto','status_penggunaan','status_pengelolaan','no_psp','tgl_psp','no_bpkb','no_polisi','pemakai'];
            $data = 'asset_alat_bermotors';
            $name = 'Alat Angkutan Bermotor';
            $this->generate($data, $var, $model, $name);
        }
    }

    private function satkerRole($table)
    {
        if($table != null && $table == 'all') {
            $satkers = Satker::get();
        } else {
            $satkers = Satker::where('satker_type', null)->get();
        }

        foreach ($satkers as $satker) {
            if(stringHasChar($satker->name, ['TINGGI'], true)) {
                $satker->type = 'tingkatbanding';
                $satker->save();
            }
        }

    }

    /**
     * @param $data
     * @param $var
     * @param $model
     * @param $name
     */
    private function generate($data, $var, $model, $name): void
    {
        $check = AssetMonitoring::whereData($data)->count();
        if($check == 0) {
            AssetMonitoring::create(['data' => $data, 'name' => $name, 'type' => 'data', 'value' => count($var)]);
            AssetMonitoring::create(['data' => $data, 'name' => $name, 'type' => 'low', 'start' => 0, 'end' => floor(count($var) / 3)]);
            AssetMonitoring::create(['data' => $data, 'name' => $name, 'type' => 'mid', 'start' => floor(count($var) / 3) + 1, 'end' => floor((count($var) / 3) * 2)]);
            AssetMonitoring::create(['data' => $data, 'name' => $name, 'type' => 'high', 'start' => (floor((count($var) / 3) * 2) + 1)]);
        }

        foreach ($model as $row) {
            $jml = 0;
            foreach ($var as $v) {
                if ($row->{$v} == null || $row->{$v} == '' || $row->{$v} == '-' || $row->{$v} == 'NULL') {

                } else {
                    $jml++;
                }
            }
            $row->filled = $jml;
            $row->save();
        }
    }
}
