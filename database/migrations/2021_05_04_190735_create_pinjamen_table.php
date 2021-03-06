<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pinjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('no_pinjaman');
            $table->date('tanggal');
            $table->double('nominal')->default(0);
            $table->decimal('bunga')->default(0);
            $table->double('bunga_rupiah')->default(0);
            $table->integer('tenor')->default(1);
            $table->timestamps();
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
        Schema::dropIfExists('pinjaman');
    }
}
