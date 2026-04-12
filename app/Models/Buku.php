<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    // ✅ Nama tabel di database adalah 'bukus'
    protected $table = 'bukus';

    // Kolom yang boleh diisi
    protected $fillable = [
        'judul',
        'pengarang',
        'penerbit',
        'kategori_id',
        'stok',
        'foto',
    ];

    // Relasi ke tabel kategoris — setiap buku punya satu kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }
}