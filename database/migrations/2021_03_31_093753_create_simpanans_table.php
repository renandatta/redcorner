<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simpanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('jenis_simpanan_id');
            $table->unsignedBigInteger('member_id');
            $table->string('no_simpanan');
            $table->date('tanggal');
            $table->double('nominal');
            $table->timestamps();
            $table->foreign('jenis_simpanan_id')->references('id')->on('jenis_simpanan');
            $table->foreign('member_id')->references('id')->on('member');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('simpanan');
    }
}
