<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';
    protected $fillable = [
        'member_id',
        'jenis_simpanan_id',
        'no_simpanan',
        'nominal',
        'tanggal'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function jenis_simpanan()
    {
        return $this->belongsTo(JenisSimpanan::class);
    }
}
