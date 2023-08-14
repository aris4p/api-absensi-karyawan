<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detailabsensis', function (Blueprint $table) {
            $table->id();
            $table->string('karyawan_id');
            $table->string('nama_karyawan');
            $table->string('jam_masuk');
            $table->string('jam_keluar');
            $table->string('keterangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detailabsensis');
    }
};
