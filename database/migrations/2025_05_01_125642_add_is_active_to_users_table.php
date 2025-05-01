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
            // Tambahkan kolom status setelah kolom 'image' (atau sesuaikan posisinya)
            // Menggunakan ENUM untuk membatasi nilai menjadi 'aktif' atau 'nonaktif'
            // Defaultnya adalah 'aktif' untuk semua user yang sudah ada
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom status jika migrasi di-rollback
            $table->dropColumn('status');
        });
    }
};
