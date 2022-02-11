<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTanahsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_tanahs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_satker');
            $table->unsignedInteger('id_barang');

            $table->unsignedTinyInteger('nup');
            $table->unsignedTinyInteger('kib');
            $table->string('kondisi', 25);
            $table->string('jenis_dokumen', 50)->nullable();
            $table->string('kepemilikan')->nullable();
            $table->string('jenis_sertifikat')->nullable();
            $table->string('merk')->nullable();
            $table->date('tgl_perolehan');
            $table->double('nilai_perolehan_pertama', 20, 2);
            $table->double('nilai_mutasi', 20, 2);
            $table->double('nilai_perolehan', 20, 2);
            $table->double('nilai_penyusutan', 20, 2);
            $table->double('nilai_buku', 20, 2);
            $table->double('kuantitasi', 20, 2);
            $table->double('luas_tanah_seluruhnya', 20, 2);
            $table->double('luas_tanah_untuk_bangunan', 20, 2);
            $table->double('luas_tanah_untuk_sarana', 20, 2);
            $table->double('luas_lahan_kosong', 20, 2);
            $table->unsignedTinyInteger('jml_foto');
            $table->string('status_penggunaan');
            $table->string('status_pengelolaan');
            $table->string('no_psp');
            $table->date('tgl_psp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('rt')->nullable();
            $table->string('kelurahan')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('kode_kabupaten', 4)->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_provinsi', 4)->nullable();
            $table->string('kode_pos', 6);
            $table->string('alamat_lainnya')->nullable();
            $table->unsignedTinyInteger('jml_kib');
            $table->unsignedTinyInteger('sbsk');
            $table->double('optimalisasi', 20, 2);

            $table->unsignedInteger('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_tanahs');
    }
}
