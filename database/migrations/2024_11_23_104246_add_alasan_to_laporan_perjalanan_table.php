<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlasanToLaporanPerjalananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->text('alasan')->nullable()->after('status'); // Kolom alasan ditambahkan setelah kolom status
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('laporan_perjalanan', function (Blueprint $table) {
            $table->dropColumn('alasan');
        });
    }
}
