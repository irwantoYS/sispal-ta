<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * @property int $id
 * @property string $no_kendaraan
 * @property string $tipe_kendaraan
 * @property float $km_per_liter
 * @property string $status
 * @property string|null $image
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $masa_berlaku_pajak
 * @property \Illuminate\Support\Carbon|null $masa_berlaku_kir
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class Kendaraan extends Model
{
    use HasFactory;
    protected $table = 'kendaraan';
    protected $primaryKey = 'id';
    protected $fillable = ['no_kendaraan', 'tipe_kendaraan', 'km_per_liter', 'status', 'image', 'is_active'];
    protected $dates = ['masa_berlaku_pajak', 'masa_berlaku_kir'];

    public function perjalanan()
    {
        return $this->hasMany(LaporanPerjalanan::class, 'kendaraan_id');
    }

    public function riwayatInspeksi() // Ganti nama method-nya
    {
        return $this->hasMany(InspeksiKendaraan::class, 'kendaraan_id');
    }

    public function inspeksis(): HasMany
    {
        return $this->hasMany(InspeksiKendaraan::class, 'kendaraan_id');
    }

    /**
     * Mendapatkan relasi ke inspeksi kendaraan TERBARU.
     */
    public function latestInspeksi(): HasOne
    {
        return $this->hasOne(InspeksiKendaraan::class)->latestOfMany();
        // Jika Anda punya kolom tanggal inspeksi spesifik (misal 'tanggal_inspeksi') 
        // dan ingin yang terbaru berdasarkan itu, gunakan:
        // return $this->hasOne(InspeksiKendaraan::class)->ofMany('tanggal_inspeksi', 'max');
    }

    protected function statusDisplay(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if ($attributes['status'] === 'ready') {
                    return '<span class="badge bg-success">Ready</span>';
                } elseif ($attributes['status'] === 'in_use') {
                    return '<span class="badge bg-info">Sedang Digunakan</span>';
                } elseif ($attributes['status'] === 'perlu_perbaikan') {
                    return '<span class="badge bg-warning">Perlu Perbaikan</span>';
                } else {
                    return $attributes['status'];
                }
            },
        );
    }
}
