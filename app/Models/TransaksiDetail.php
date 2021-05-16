<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed qty
 * @property mixed harga
 */
class TransaksiDetail extends Model
{
    protected $table = 'transaksi_detail';
    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'qty',
        'harga',
        'harga_beli',
    ];

    public function getTotalAttribute()
    {
        return $this->qty * $this->harga;
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}
