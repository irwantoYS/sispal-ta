<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $table = 'kendaraan';
    protected $primaryKey = 'id';
    protected $fillable = ['no_kendaraan','tipe_kendaraan','km_per_liter','status','image'];

    public function perjalanan(){
        return $this->hasMany(LaporanPerjalanan::class, 'kendaraan_id');
    }
}

