<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayananTambalBanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanan_tambal_ban', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tambal_ban_id')->unsigned()->nullable();
            $table->foreign('tambal_ban_id')->references('id')->on('tambal_ban')->onUpdate('cascade')->onDelete('restrict');
            $table->integer('layanan_id')->unsigned()->nullable();
            $table->foreign('layanan_id')->references('id')->on('layanan')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanan_tambal_ban');
    }
}
