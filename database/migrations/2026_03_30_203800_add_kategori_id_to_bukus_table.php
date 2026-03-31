<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropColumn('kategori');
            $table->foreignId('kategori_id')->nullable()->constrained('kategoris')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('bukus', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
            $table->string('kategori')->nullable();
        });
    }
};