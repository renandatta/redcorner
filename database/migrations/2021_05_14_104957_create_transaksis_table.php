<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('no_transaksi');
            $table->date('tanggal');
            $table->double('harga_produk')->nullable();
            $table->double('biaya_pengiriman')->nullable();
            $table->double('diskon')->nullable();
            $table->double('total_biaya')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->string('kodepos')->nullable();
            $table->string('notelp')->nullable();
            $table->string('no_resi')->nullable();
            $table->string('status')->nullable();
            $table->string('rekening_bank')->nullable();
            $table->string('rekening_no')->nullable();
            $table->string('rekening_nama')->nullable();
            $table->string('nominal_transfer')->nullable();
            $table->string('file_bukti')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi');
    }
}
