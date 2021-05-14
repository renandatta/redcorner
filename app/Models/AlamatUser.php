<?php

namespace App\Models;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatUser extends Model
{
    protected $table = 'alamat_user';
    protected $fillable = [
        'user_id',
        'alamat',
        'kodepos',
        'nama_penerima',
        'notelp'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
