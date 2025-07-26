<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pengemudi_id
 * @property string $nama_pegawai
 * @property string $titik_awal
 * @property string $titik_akhir
 * @property string $tujuan_perjalanan
 * @property int $kendaraan_id
 * @property float|null $km_awal
 * @property float|null $km_akhir
 * @property float|null $bbm_awal
 * @property float|null $bbm_akhir
 * @property string|null $jenis_bbm
 * @property float|null $km_awal_manual
 * @property float|null $km_akhir_manual
 * @property float|null $total_km_manual
 * @property \Illuminate\Support\Carbon|null $jam_pergi
 * @property \Illuminate\Support\Carbon|null $jam_kembali
 * @property string $status
 * @property string|null $alasan
 * @property float|null $estimasi_jarak
 * @property string|null $estimasi_waktu
 * @property string|null $foto_awal
 * @property string|null $foto_akhir
 * @property float|null $estimasi_bbm
 * @property string|null $previous_kendaraan_status
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property int|null $validated_by
 * @property-read Kendaraan $kendaraan
 * @property-read User $user
 * @property-read User $validator
 */
class LaporanPerjalanan extends Model
{
    use HasFactory;
    protected $table = 'laporan_perjalanan';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pengemudi_id',
        'nama_pegawai',
        'titik_awal',
        'titik_akhir',
        'tujuan_perjalanan',
        'kendaraan_id',
        'km_awal',
        'km_akhir',
        'bbm_awal',
        'bbm_akhir',
        'jenis_bbm',
        'km_awal_manual',
        'km_akhir_manual',
        'total_km_manual',
        'jam_pergi',
        'jam_kembali',
        'status',
        'alasan',
        'estimasi_jarak',
        'estimasi_waktu',
        'foto_awal',
        'foto_akhir',
        'estimasi_bbm',
        'previous_kendaraan_status'
    ];

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pengemudi_id');
    }

    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
