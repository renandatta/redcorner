<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembayaranPinjaman extends Model
{
    protected $table = 'pembayaran_pinjaman';
    protected $fillable = [
        'pinjaman_id',
        'tanggal',
        'pembayaran_ke',
        'nominal'
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }

    public function getAngsuranPokokAttribute()
    {
        $bunga_rupiah = $this->pinjaman->bunga_rupiah;
        return $this->nominal - $bunga_rupiah;
    }
}
