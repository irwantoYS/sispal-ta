<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DcuRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shift',
        'sistolik',
        'diastolik',
        'nadi',
        'pernapasan',
        'spo2',
        'suhu_tubuh',
        'mata',
        'kesimpulan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
