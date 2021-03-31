<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
