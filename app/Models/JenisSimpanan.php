<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSimpanan extends Model
{
    const TIPE = array('Rutin', 'Isidentil');
    protected $table = 'jenis_simpanan';
    protected $fillable = [
        'nama',
        'tipe',
        'nominal'
    ];
}
