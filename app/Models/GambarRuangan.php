<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarRuangan extends Model
{
    protected $table = 'gambar_ruangan';
    protected $fillable = [
        'ruangan_id',
        'file'
    ];
}
