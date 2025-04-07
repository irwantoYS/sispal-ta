<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InspeksiKendaraan extends Model
{
    use HasFactory;

    protected $table = 'inspeksi_kendaraan';

    protected $fillable = [
        'kendaraan_id',
        'user_id',
        'tanggal_inspeksi',
        'body_baik',
        'body_keterangan',
        'ban_baik',
        'ban_keterangan',
        'stir_baik',
        'stir_keterangan',
        'rem_kaki_tangan_baik',
        'rem_kaki_tangan_keterangan',
        'pedal_kopling_gas_rem_baik',
        'pedal_kopling_gas_rem_keterangan',
        'starter_baik',
        'starter_keterangan',
        'oli_mesin_baik',
        'oli_mesin_keterangan',
        'tangki_bb_pompa_baik',
        'tangki_bb_pompa_keterangan',
        'radiator_pompa_fanbelt_baik',
        'radiator_pompa_fanbelt_keterangan',
        'transmisi_baik',
        'transmisi_keterangan',
        'knalpot_baik',
        'knalpot_keterangan',
        'klakson_baik',
        'klakson_keterangan',
        'alarm_mundur_baik',
        'alarm_mundur_keterangan',
        'lampu_depan_baik',
        'lampu_depan_keterangan',
        'lampu_sign_baik',
        'lampu_sign_keterangan',
        'lampu_kabin_pintu_baik',
        'lampu_kabin_pintu_keterangan',
        'lampu_rem_baik',
        'lampu_rem_keterangan',
        'lampu_mundur_baik',
        'lampu_mundur_keterangan',
        'lampu_drl_baik',
        'lampu_drl_keterangan',
        'indikator_kecepatan_baik',
        'indikator_kecepatan_keterangan',
        'indikator_bb_baik',
        'indikator_bb_keterangan',
        'indikator_temperatur_baik',
        'indikator_temperatur_keterangan',
        'lampu_depan_belakang_baik', //Perbaikan: indikator lampu depan dan belakang
        'lampu_depan_belakang_keterangan',//Perbaikan: indikator lampu depan dan belakang
        'lampu_rem2_baik', //Perbaikan: indikator Lampu Rem
        'lampu_rem2_keterangan', //Perbaikan: indikator Lampu Rem
        'baut_roda_baik',
        'baut_roda_keterangan',
        'jendela_baik',
        'jendela_keterangan',
        'wiper_washer_baik',
        'wiper_washer_keterangan',
        'spion_baik',
        'spion_keterangan',
        'kunci_pintu_baik',
        'kunci_pintu_keterangan',
        'kursi_baik',
        'kursi_keterangan',
        'sabuk_keselamatan_baik',
        'sabuk_keselamatan_keterangan',
        'apar_baik',
        'apar_keterangan',
        'perlengkapan_kebocoran_baik',
        'perlengkapan_kebocoran_keterangan',
        'segitiga_pengaman_baik',
        'segitiga_pengaman_keterangan',
        'safety_cone_baik',
        'safety_cone_keterangan',
        'dongkrak_kunci_baik',
        'dongkrak_kunci_keterangan',
        'ganjal_ban_baik',
        'ganjal_ban_keterangan',
        'kotak_p3k_baik',
        'kotak_p3k_keterangan',
        'dokumen_rutin_baik',
        'dokumen_rutin_keterangan',
        'dokumen_service_baik',
        'dokumen_service_keterangan',
        'pengemudi_sehat_baik',  // Data kondisi pengemudi
        'pengemudi_sehat_keterangan',
        'pengemudi_istirahat_baik',
        'pengemudi_istirahat_keterangan',
        'pengemudi_mabuk_baik',
        'pengemudi_mabuk_keterangan',
        'pengemudi_obat_baik',
        'pengemudi_obat_keterangan',
        'catatan',
        'status',
    ];

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}