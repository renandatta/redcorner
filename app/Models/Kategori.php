<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = [
        'nama',
        'slug',
        'kode',
        'parent_kode'
    ];

    public function setNamaAttribute($nama)
    {
        $this->attributes['nama'] = $nama;
        $this->attributes['slug'] = Str::slug($nama);
    }
}
