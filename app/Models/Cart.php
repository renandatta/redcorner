<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed produk
 * @property mixed qty
 */
class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'produk_id',
        'qty'
    ];
    protected $with = ['produk'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }

    public function getTotalAttribute()
    {
        return $this->produk->harga * $this->qty;
    }

    public function getTotalHargaBeliAttribute()
    {
        return $this->produk->harga * $this->qty;
    }
}
