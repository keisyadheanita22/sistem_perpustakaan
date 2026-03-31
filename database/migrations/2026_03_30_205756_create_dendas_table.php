<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjamans')->onDelete('cascade');
            $table->string('nama_anggota');
            $table->string('judul_buku');
            $table->integer('hari_terlambat');
            $table->integer('denda_per_hari');
            $table->integer('total_denda');
            $table->enum('status_bayar', ['belum_bayar', 'sudah_bayar'])->default('belum_bayar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};