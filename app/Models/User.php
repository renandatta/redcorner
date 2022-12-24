<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const ROLES = array('Administrator', 'User', 'Operator');
    use HasFactory, Notifiable;
    protected $fillable = [
        'nama',
        'email',
        'role',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function alamat()
    {
        return $this->hasOne(AlamatUser::class);
    }
}
