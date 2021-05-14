<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
        'user_id',
        'no_transaksi',
        'tanggal',
        'harga_produk',
        'biaya_pengiriman',
        'diskon',
        'total_biaya',
        'nama_penerima',
        'alamat_pengiriman',
        'kodepos',
        'no_resi',
        'status',
        'rekening_bank',
        'rekening_no',
        'rekening_nama',
        'nominal_transfer',
        'file_bukti',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id', 'id');
    }
}
