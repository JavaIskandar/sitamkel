<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTambalBanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tambal_ban', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama');
            $table->string('lat');
            $table->string('lng');
            $table->string('jam_kerja');
            $table->string('no_telp');
            $table->string('keterangan');
            $table->string('alamat');
            $table->string('gambar');
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
        Schema::dropIfExists('tambal_ban');
    }
}
