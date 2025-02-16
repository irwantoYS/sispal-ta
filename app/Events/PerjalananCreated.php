<?php

namespace App\Events;

use App\Models\LaporanPerjalanan; // Model perjalanan Anda
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PerjalananCreated
{
    use Dispatchable, SerializesModels;
    public $perjalanan;
    public function __construct(LaporanPerjalanan $perjalanan) { $this->perjalanan = $perjalanan; }
}

