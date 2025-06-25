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
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->enum('jenis_bbm', ['Solar', 'Pertalite', 'Pertamax'])->nullable()->after('bbm_awal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->dropColumn('jenis_bbm');
        });
    }
};
