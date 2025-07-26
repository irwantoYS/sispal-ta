<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $shift
 * @property int $sistolik
 * @property int $diastolik
 * @property int $nadi
 * @property int $pernapasan
 * @property int $spo2
 * @property float $suhu_tubuh
 * @property string $mata
 * @property string $kesimpulan
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read User $user
 */
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
