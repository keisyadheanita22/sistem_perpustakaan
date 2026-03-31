<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->string('id_anggota');
            $table->string('nama_anggota');
            $table->foreignId('buku_id')->constrained('bukus')->onDelete('cascade');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->enum('status', ['dipinjam', 'dikembalikan'])->default('dipinjam');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};