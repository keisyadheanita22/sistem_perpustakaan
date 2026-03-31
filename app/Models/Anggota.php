<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_anggota',
        'nama',
        'email',
        'no_telepon',
        'alamat',
        'username',
        'password',
    ];

    protected $hidden = ['password'];
}