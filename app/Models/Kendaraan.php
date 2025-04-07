<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Kendaraan extends Model
{
    use HasFactory;
    protected $table = 'kendaraan';
    protected $primaryKey = 'id';
    protected $fillable = ['no_kendaraan', 'tipe_kendaraan', 'km_per_liter', 'status', 'image'];

    public function perjalanan()
    {
        return $this->hasMany(LaporanPerjalanan::class, 'kendaraan_id');
    }

    public function riwayatInspeksi() // Ganti nama method-nya
    {
        return $this->hasMany(InspeksiKendaraan::class, 'kendaraan_id');
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
