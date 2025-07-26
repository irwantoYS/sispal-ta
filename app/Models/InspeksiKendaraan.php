<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $kendaraan_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon $tanggal_inspeksi
 * @property bool $body_baik
 * @property string|null $body_keterangan
 * @property bool $ban_baik
 * @property string|null $ban_keterangan
 * @property bool $stir_baik
 * @property string|null $stir_keterangan
 * @property bool $rem_kaki_tangan_baik
 * @property string|null $rem_kaki_tangan_keterangan
 * @property bool $pedal_kopling_gas_rem_baik
 * @property string|null $pedal_kopling_gas_rem_keterangan
 * @property bool $starter_baik
 * @property string|null $starter_keterangan
 * @property bool $oli_mesin_baik
 * @property string|null $oli_mesin_keterangan
 * @property bool $tangki_bb_pompa_baik
 * @property string|null $tangki_bb_pompa_keterangan
 * @property bool $radiator_pompa_fanbelt_baik
 * @property string|null $radiator_pompa_fanbelt_keterangan
 * @property bool $transmisi_baik
 * @property string|null $transmisi_keterangan
 * @property bool $knalpot_baik
 * @property string|null $knalpot_keterangan
 * @property bool $klakson_baik
 * @property string|null $klakson_keterangan
 * @property bool $alarm_mundur_baik
 * @property string|null $alarm_mundur_keterangan
 * @property bool $lampu_depan_baik
 * @property string|null $lampu_depan_keterangan
 * @property bool $lampu_sign_baik
 * @property string|null $lampu_sign_keterangan
 * @property bool $lampu_kabin_pintu_baik
 * @property string|null $lampu_kabin_pintu_keterangan
 * @property bool $lampu_rem_baik
 * @property string|null $lampu_rem_keterangan
 * @property bool $lampu_mundur_baik
 * @property string|null $lampu_mundur_keterangan
 * @property bool $lampu_drl_baik
 * @property string|null $lampu_drl_keterangan
 * @property bool $indikator_kecepatan_baik
 * @property string|null $indikator_kecepatan_keterangan
 * @property bool $indikator_bb_baik
 * @property string|null $indikator_bb_keterangan
 * @property bool $indikator_temperatur_baik
 * @property string|null $indikator_temperatur_keterangan
 * @property bool $lampu_depan_belakang_baik
 * @property string|null $lampu_depan_belakang_keterangan
 * @property bool $lampu_rem2_baik
 * @property string|null $lampu_rem2_keterangan
 * @property bool $baut_roda_baik
 * @property string|null $baut_roda_keterangan
 * @property bool $jendela_baik
 * @property string|null $jendela_keterangan
 * @property bool $wiper_washer_baik
 * @property string|null $wiper_washer_keterangan
 * @property bool $spion_baik
 * @property string|null $spion_keterangan
 * @property bool $kunci_pintu_baik
 * @property string|null $kunci_pintu_keterangan
 * @property bool $kursi_baik
 * @property string|null $kursi_keterangan
 * @property bool $sabuk_keselamatan_baik
 * @property string|null $sabuk_keselamatan_keterangan
 * @property bool $apar_baik
 * @property string|null $apar_keterangan
 * @property bool $perlengkapan_kebocoran_baik
 * @property string|null $perlengkapan_kebocoran_keterangan
 * @property bool $segitiga_pengaman_baik
 * @property string|null $segitiga_pengaman_keterangan
 * @property bool $safety_cone_baik
 * @property string|null $safety_cone_keterangan
 * @property bool $dongkrak_kunci_baik
 * @property string|null $dongkrak_kunci_keterangan
 * @property bool $ganjal_ban_baik
 * @property string|null $ganjal_ban_keterangan
 * @property bool $kotak_p3k_baik
 * @property string|null $kotak_p3k_keterangan
 * @property bool $dokumen_rutin_baik
 * @property string|null $dokumen_rutin_keterangan
 * @property bool $dokumen_service_baik
 * @property string|null $dokumen_service_keterangan
 * @property bool $pengemudi_sehat_baik
 * @property string|null $pengemudi_sehat_keterangan
 * @property bool $pengemudi_istirahat_baik
 * @property string|null $pengemudi_istirahat_keterangan
 * @property bool $pengemudi_mabuk_baik
 * @property string|null $pengemudi_mabuk_keterangan
 * @property bool $pengemudi_obat_baik
 * @property string|null $pengemudi_obat_keterangan
 * @property string|null $catatan
 * @property string $status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read Kendaraan $kendaraan
 * @property-read User $user
 */
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
        'lampu_depan_belakang_keterangan', //Perbaikan: indikator lampu depan dan belakang
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
