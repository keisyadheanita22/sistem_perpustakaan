<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah nilai 'mengembalikan' ke kolom status
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('menunggu', 'dipinjam', 'mengembalikan', 'dikembalikan') NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        // Rollback ke enum sebelumnya
        DB::statement("ALTER TABLE peminjamans MODIFY COLUMN status ENUM('menunggu', 'dipinjam', 'dikembalikan') NOT NULL DEFAULT 'menunggu'");
    }
};