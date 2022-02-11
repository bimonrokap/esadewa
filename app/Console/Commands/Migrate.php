<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class Migrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:init';

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
        echo "----------------------------Start of Migrate----------------------------\n\n";

        $dropTables = [
            'alih_fungsis',
            'barangs',
            'form_inputs',
            'form_selects',
            'forms',
            'hibah_keluars',
            'hibah_masuks',
            'izin_membongkars',
            'lapor_bmn_replies',
            'kategoris',
            'object_inputs',
            'pemusnahans',
            'pengadaan_barangs',
            'penghapusans',
            'penjualan_bongkarans',
            'penjualans',
            'psps',
            'satkers_copy1',
            'sewa_barangs',
            'status_alih_fungsis',
            'status_hibah_keluars',
            'status_hibah_masuks',
            'sewa_statuses',
            'status_izin_membongkars',
            'status_pemusnahans',
            'status_pengadaan_barangs',
            'status_penghapusans',
            'status_penjualan_bongkarans',
            'status_penjualans',
            'status_psps',
            'status_sewas',
            'status_tukar_menukars',
            'tukar_menukars',
            'usulan_barangs',
            'usulan_categories',
            'usulan_verif_forms',
            'usulan_verifs',
        ];

//        $dropViews = [
//            'view_barang_alih_fungsi',
//            'view_barang_penghapusan',
//            'view_barang_penjualan',
//            'view_barang_psp',
//            'view_barang_sewa',
//            'view_document_barang',
//            'view_total_psp'
//        ];

        foreach ($dropTables as $table) {
            echo "Drop Unused Table $table.\n";
            \DB::statement("DROP TABLE IF EXISTS `$table`;");
        }
//        foreach ($dropViews as $table) {
//            echo "Drop Unused View $table.\n";
//            \DB::statement("DROP VIEW IF EXISTS `$table`;");
//        }

        echo "\nStart -> Import New Table and Populate Data\n";
        \DB::unprepared(file_get_contents(base_path('import.sql')));
        if (!Schema::hasColumn('asset_air_irigasis', 'jalan')) {
            \DB::statement("ALTER TABLE asset_air_irigasis ADD jalan varchar(255) DEFAULT NULL;");
        }
        if (!Schema::hasColumn('asset_instalasi_jaringans', 'jalan')) {
            \DB::statement("ALTER TABLE asset_instalasi_jaringans ADD jalan varchar(255) DEFAULT NULL;");
        }

        if (!Schema::hasColumn('satkers', 'satker_type')) {
            \DB::statement("ALTER TABLE satkers ADD satker_type varchar(10) DEFAULT NULL AFTER type;");
        }
        if (!Schema::hasColumn('satkers', 'kanwil')) {
            \DB::statement("ALTER TABLE satkers ADD kanwil varchar(100) DEFAULT NULL AFTER type;");
        }
        if (!Schema::hasColumn('satkers', 'kpknl')) {
            \DB::statement("ALTER TABLE satkers ADD kpknl varchar(100) DEFAULT NULL AFTER type;");
        }
        if (!Schema::hasColumn('satkers', 'dirjen')) {
            \DB::statement("ALTER TABLE satkers ADD dirjen varchar(100) DEFAULT NULL AFTER type;");
        }
        if (!Schema::hasColumn('satkers', 'city')) {
            \DB::statement("ALTER TABLE satkers ADD city varchar(100) DEFAULT NULL AFTER type;");
        }

        \DB::statement("ALTER TABLE satkers DROP INDEX kode;");
        \DB::statement("CREATE INDEX kode ON satkers (kode);");

        \DB::statement("ALTER TABLE asset_rumah_negaras MODIFY tgl_perolehan VARCHAR(255) DEFAULT NULL;");
        \DB::statement("ALTER TABLE asset_rumah_negaras MODIFY tgl_psp VARCHAR(255) DEFAULT NULL;");

        \DB::statement("ALTER TABLE asset_tak_berwujuds MODIFY tgl_perolehan VARCHAR(255) DEFAULT NULL;");
        \DB::statement("ALTER TABLE asset_tak_berwujuds MODIFY tgl_psp VARCHAR(255) DEFAULT NULL;");

        \DB::statement("ALTER TABLE asset_tetap_lainnyas MODIFY tgl_psp VARCHAR(255) DEFAULT NULL;");

        echo "\nEnd -> Import New Table and Populate Data\n";

        $this->call('monitoring:generate');

        echo "----------------------------End of Migrate----------------------------";

    }
}
