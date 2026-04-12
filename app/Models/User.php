<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // ✅ Tambah 'alamat' ke fillable agar bisa disimpan saat register
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'id_anggota',
        'no_telepon',
        'username',
        'foto',
        'alamat',    // ✅ Tambahan baru — data alamat anggota
    ];

    // Kolom yang disembunyikan saat dijadikan array/JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast tipe data kolom tertentu
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}