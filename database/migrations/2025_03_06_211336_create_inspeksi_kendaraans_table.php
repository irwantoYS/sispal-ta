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
        Schema::create('inspeksi_kendaraan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kendaraan_id')->constrained('kendaraan')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal_inspeksi');

            // Bagian 1: Body, Ban, dll.
            $table->boolean('body_baik')->default(true);
            $table->string('body_keterangan')->nullable();
            $table->boolean('ban_baik')->default(true);
            $table->string('ban_keterangan')->nullable();
            $table->boolean('stir_baik')->default(true);
            $table->string('stir_keterangan')->nullable();
            $table->boolean('rem_kaki_tangan_baik')->default(true);
            $table->string('rem_kaki_tangan_keterangan')->nullable();
            $table->boolean('pedal_kopling_gas_rem_baik')->default(true);
            $table->string('pedal_kopling_gas_rem_keterangan')->nullable();
            $table->boolean('starter_baik')->default(true);
            $table->string('starter_keterangan')->nullable();
            $table->boolean('oli_mesin_baik')->default(true);
            $table->string('oli_mesin_keterangan')->nullable();
            $table->boolean('tangki_bb_pompa_baik')->default(true);
            $table->string('tangki_bb_pompa_keterangan')->nullable();
            $table->boolean('radiator_pompa_fanbelt_baik')->default(true);
            $table->string('radiator_pompa_fanbelt_keterangan')->nullable();
            $table->boolean('transmisi_baik')->default(true);
            $table->string('transmisi_keterangan')->nullable();
            $table->boolean('knalpot_baik')->default(true);
            $table->string('knalpot_keterangan')->nullable();
            $table->boolean('klakson_baik')->default(true);
            $table->string('klakson_keterangan')->nullable();
            $table->boolean('alarm_mundur_baik')->default(true);
            $table->string('alarm_mundur_keterangan')->nullable();

            // Lampu
            $table->boolean('lampu_depan_baik')->default(true);
            $table->string('lampu_depan_keterangan')->nullable();
            $table->boolean('lampu_sign_baik')->default(true);
            $table->string('lampu_sign_keterangan')->nullable();
            $table->boolean('lampu_kabin_pintu_baik')->default(true);
            $table->string('lampu_kabin_pintu_keterangan')->nullable();
            $table->boolean('lampu_rem_baik')->default(true);
            $table->string('lampu_rem_keterangan')->nullable();
            $table->boolean('lampu_mundur_baik')->default(true);
            $table->string('lampu_mundur_keterangan')->nullable();
            $table->boolean('lampu_drl_baik')->default(true);
            $table->string('lampu_drl_keterangan')->nullable();

            // Panel Indikator
            $table->boolean('indikator_kecepatan_baik')->default(true);
            $table->string('indikator_kecepatan_keterangan')->nullable();
            $table->boolean('indikator_bb_baik')->default(true);
            $table->string('indikator_bb_keterangan')->nullable();
            $table->boolean('indikator_temperatur_baik')->default(true);
            $table->string('indikator_temperatur_keterangan')->nullable();
            $table->boolean('lampu_depan_belakang_baik')->default(true);
            $table->string('lampu_depan_belakang_keterangan')->nullable();
            $table->boolean('lampu_rem2_baik')->default(true);
            $table->string('lampu_rem2_keterangan')->nullable();
            $table->boolean('baut_roda_baik')->default(true);
            $table->string('baut_roda_keterangan')->nullable();

            // ... (lanjutkan untuk item lainnya) ...
            $table->boolean('jendela_baik')->default(true);
            $table->string('jendela_keterangan')->nullable();
            $table->boolean('wiper_washer_baik')->default(true);
            $table->string('wiper_washer_keterangan')->nullable();
            $table->boolean('spion_baik')->default(true);
            $table->string('spion_keterangan')->nullable();
            $table->boolean('kunci_pintu_baik')->default(true);
            $table->string('kunci_pintu_keterangan')->nullable();
            $table->boolean('kursi_baik')->default(true);
            $table->string('kursi_keterangan')->nullable();
            $table->boolean('sabuk_keselamatan_baik')->default(true);
            $table->string('sabuk_keselamatan_keterangan')->nullable();
            $table->boolean('apar_baik')->default(true);
            $table->string('apar_keterangan')->nullable();
            $table->boolean('perlengkapan_kebocoran_baik')->default(true);
            $table->string('perlengkapan_kebocoran_keterangan')->nullable();
            $table->boolean('segitiga_pengaman_baik')->default(true);
            $table->string('segitiga_pengaman_keterangan')->nullable();
            $table->boolean('safety_cone_baik')->default(true);
            $table->string('safety_cone_keterangan')->nullable();
            $table->boolean('dongkrak_kunci_baik')->default(true);
            $table->string('dongkrak_kunci_keterangan')->nullable();
            $table->boolean('ganjal_ban_baik')->default(true);
            $table->string('ganjal_ban_keterangan')->nullable();
            $table->boolean('kotak_p3k_baik')->default(true);
            $table->string('kotak_p3k_keterangan')->nullable();
            $table->boolean('dokumen_rutin_baik')->default(true);
            $table->string('dokumen_rutin_keterangan')->nullable();
            $table->boolean('dokumen_service_baik')->default(true);
            $table->string('dokumen_service_keterangan')->nullable();

            // Pengemudi
            $table->boolean('pengemudi_sehat_baik')->default(true);
            $table->string('pengemudi_sehat_keterangan')->nullable();
            $table->boolean('pengemudi_istirahat_baik')->default(true);
            $table->string('pengemudi_istirahat_keterangan')->nullable();
            $table->boolean('pengemudi_mabuk_baik')->default(true);
            $table->string('pengemudi_mabuk_keterangan')->nullable();
            $table->boolean('pengemudi_obat_baik')->default(true);
            $table->string('pengemudi_obat_keterangan')->nullable();
            $table->string('catatan')->nullable();
            $table->string('status');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspeksi_kendaraan');
    }
};