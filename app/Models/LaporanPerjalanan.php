<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
