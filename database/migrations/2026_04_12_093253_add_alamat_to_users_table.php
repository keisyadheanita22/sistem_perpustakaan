<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // ===== Tambah kolom alamat ke tabel users =====
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom alamat setelah kolom username
            // nullable() agar data users lama tidak error
            $table->text('alamat')->nullable()->after('username');
        });
    }

    // ===== Rollback: hapus kolom alamat dari tabel users =====
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('alamat');
        });
    }
};