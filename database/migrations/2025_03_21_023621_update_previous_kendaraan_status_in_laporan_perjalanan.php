<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update laporan_perjalanan berdasarkan status asli kendaraan
        $perjalananWithNullStatus = DB::table('laporan_perjalanan as lp')
            ->join('kendaraan as k', 'lp.kendaraan_id', '=', 'k.id')
            ->whereNull('lp.previous_kendaraan_status')
            ->select('lp.id', 'k.status')
            ->get();

        foreach ($perjalananWithNullStatus as $perjalanan) {
            DB::table('laporan_perjalanan')
                ->where('id', $perjalanan->id)
                ->update(['previous_kendaraan_status' => $perjalanan->status]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Anda *tidak perlu* melakukan apa pun di sini, karena ini hanya update data.
        // Kosongkan saja method down() atau throw exception jika diperlukan.
        Schema::table('laporan_perjalanan', function (Blueprint $table) {});
    }
};
