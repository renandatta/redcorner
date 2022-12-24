<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';
    protected $fillable = [
        'member_id',
        'no_pinjaman',
        'tanggal',
        'nominal',
        'bunga',
        'bunga_rupiah',
        'tenor',
        'angsuran'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function pembayaran_pinjaman()
    {
        return $this->hasMany(PembayaranPinjaman::class);
    }

    public function getBungaRupiah2Attribute()
    {
        return $this->nominal * ($this->bunga / 100);
    }

    public function getAngsuranAttribute()
    {
        return $this->nominal / $this->tenor;
    }

    public function getTotalAngsuranAttribute()
    {
        return $this->angsuran + $this->bunga_rupiah_2;
    }

    public function getDibayarPokokAttribute()
    {
        return $this->pembayaran_pinjaman->sum('angsuran_pokok');
    }
}
