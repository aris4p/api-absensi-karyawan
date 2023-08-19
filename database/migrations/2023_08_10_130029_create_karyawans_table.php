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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('id_pegawai');
            $table->string('passsowrd');
            $table->string('nama_karyawan');
            $table->date('tgl_lahir');
            $table->string('jenis_kelamin');
            $table->string('alamat');
            $table->bigInteger('no_tlp');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('status');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();

            $table->foreign('jabatan_id')->references('id')->on('jabatans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('karyawans');
    }
};
