<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Produk extends Model
{
    protected $table = 'produk';
    protected $fillable = [
        'kategori_id',
        'nama',
        'harga',
        'tag',
        'keterangan'
    ];

    public function setNamaAttribute($nama)
    {
        $this->attributes['nama'] = $nama;
        $this->attributes['slug'] = Str::slug($nama);
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function gambar()
    {
        return $this->hasMany(GambarProduk::class, 'produk_id', 'id');
    }

    public function is_wishlist()
    {
        return $this->hasOne(Wishlist::class, 'produk_id', 'id')
            ->where('user_id', Auth::user()->id ?? '');
    }
}
