<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    const JENIS_KELAMIN = array('L', 'P');
    protected $table = 'member';
    protected $fillable = [
        'nama',
        'nik',
        'jenis_kelamin',
        'alamat',
        'notelp',
    ];
}
