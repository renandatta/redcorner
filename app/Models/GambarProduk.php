<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarProduk extends Model
{
    protected $table = 'gambar_produk';
    protected $fillable = [
        'produk_id',
        'file'
    ];
}
