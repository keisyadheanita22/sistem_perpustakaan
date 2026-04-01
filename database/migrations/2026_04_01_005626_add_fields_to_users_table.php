<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('id_anggota')->nullable()->unique()->after('name');
        $table->string('no_telepon')->nullable()->after('email');
        $table->string('username')->nullable()->unique()->after('no_telepon');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['id_anggota', 'no_telepon', 'username']);
    });
}
};
