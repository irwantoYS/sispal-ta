<?php

namespace App\Events;

use App\Models\LaporanPerjalanan;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PerjalananStatusUpdated
{
    use Dispatchable, SerializesModels;
    public $perjalanan;
    public $status;
    public function __construct(LaporanPerjalanan $perjalanan, $status) {
        $this->perjalanan = $perjalanan;
        $this->status = $status;
    }
}

