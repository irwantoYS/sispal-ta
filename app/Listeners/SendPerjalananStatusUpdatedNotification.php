<?php

namespace App\Listeners;

use App\Events\PerjalananStatusUpdated;
use App\Mail\PerjalananNotification;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPerjalananStatusUpdatedNotification implements ShouldQueue
{
    public function handle(PerjalananStatusUpdated $event): void
    {
        $driver = $event->perjalanan->user;
        Mail::to($driver->email)->send(new PerjalananNotification($event->perjalanan, $event->status, $driver));
        Notification::create([
            'type' => 'perjalanan_' . $event->status, 'notifiable_type' => get_class($driver), 'notifiable_id' => $driver->id,
            'data' => ['perjalanan_id' => $event->perjalanan->id, 'status' => $event->status,
                'pesan' => "Perjalanan Anda " . ($event->status === 'disetujui' ? 'disetujui' : 'ditolak') . " oleh Manager Area."],
        ]);
    }
}
