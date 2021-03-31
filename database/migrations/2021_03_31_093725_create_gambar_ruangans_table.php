<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGambarRuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gambar_ruangan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ruangan_id');
            $table->string('file');
            $table->timestamps();
            $table->foreign('ruangan_id')->references('id')->on('ruangan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gambar_ruangan');
    }
}
