<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

   protected $fillable = [
    'id_peminjaman',
    'id_anggota',
    'nama_anggota',
    'buku_id',
    'tanggal_pinjam',
    'tanggal_kembali',
    'status',
];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
}