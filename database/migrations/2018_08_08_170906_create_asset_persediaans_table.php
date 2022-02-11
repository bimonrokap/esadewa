<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetPersediaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_persediaans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_satker');
            $table->unsignedInteger('id_barang');
            $table->tinyInteger('tahun')->nullable();
            $table->string('periode')->nullable();
            $table->tinyInteger('kuantitas');
            $table->double('nilai', 20, 2);

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
        Schema::dropIfExists('asset_persediaans');
    }
}
