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
            $table->integer('km_awal_manual')->nullable()->after('km_akhir');
            $table->integer('km_akhir_manual')->nullable()->after('km_awal_manual');
            $table->integer('total_km_manual')->nullable()->after('km_akhir_manual');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->dropColumn('km_awal_manual');
            $table->dropColumn('km_akhir_manual');
            $table->dropColumn('total_km_manual');
        });
    }
};
