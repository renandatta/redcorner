<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ruangan extends Model
{
    protected $table = 'ruangan';
    protected $fillable = [
        'nama',
        'slug',
        'tag',
        'harga',
        'keterangan'
    ];

    public function setNamaAttribute($nama)
    {
        $this->attributes['nama'] = $nama;
        $this->attributes['slug'] = Str::slug($nama);
    }

    public function gambar()
    {
        return $this->hasMany(GambarRuangan::class, 'ruangan_id', 'id');
    }
}
