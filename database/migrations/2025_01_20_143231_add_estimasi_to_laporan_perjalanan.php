<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->string('estimasi_jarak')->nullable()->after('titik_akhir');
            $table->string('estimasi_waktu')->nullable()->after('estimasi_jarak');
            $table->string('foto_awal')->nullable()->after('estimasi_waktu');
            $table->string('foto_akhir')->nullable()->after('foto_awal');
            $table->string('estimasi_bbm')->nullable()->after('foto_akhir');
        });
    }

    public function down()
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->dropColumn(['estimasi_jarak', 'estimasi_waktu', 'foto_awal', 'foto_akhir', 'estimasi_bbm']);
        });
    }
};
