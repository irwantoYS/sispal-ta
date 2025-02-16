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
        Schema::create('laporan_perjalanan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('pengemudi_id');
            $table->string('nama_pegawai');
            $table->string('titik_awal');
            $table->string('titik_akhir');
            $table->string('tujuan_perjalanan');
            $table->unsignedBigInteger('kendaraan_id');
            $table->integer('km_awal');
            $table->integer('km_akhir')->nullable();
            $table->integer('bbm_awal');
            $table->integer('bbm_akhir')->nullable();
            $table->dateTime('jam_pergi');
            $table->dateTime('jam_kembali')->nullable();
            $table->string('status')->nullable(); // Biarkan null jika status opsional

            // Menambahkan foreign key constraint
            $table->foreign('kendaraan_id')->references('id')->on('kendaraan')->onDelete('cascade');
            $table->foreign('pengemudi_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_perjalanan');
    }
};
