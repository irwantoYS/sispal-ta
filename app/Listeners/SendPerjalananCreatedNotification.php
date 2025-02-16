<?php

namespace App\Listeners;

use App\Events\PerjalananCreated;
use App\Mail\PerjalananNotification; // Mailable
use App\Models\Notification;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendPerjalananCreatedNotification implements ShouldQueue
{
    public function handle(PerjalananCreated $event): void
    {
        $managerArea = User::where('role', 'managerarea')->first(); // Sesuaikan
        if ($managerArea) {
            Mail::to($managerArea->email)->send(new PerjalananNotification($event->perjalanan, 'baru', $managerArea));
            Notification::create([
                'type' => 'perjalanan_baru', 'notifiable_type' => get_class($managerArea), 'notifiable_id' => $managerArea->id,
                'data' => ['perjalanan_id' => $event->perjalanan->id, 'driver' => $event->perjalanan->user->nama,
                    'pesan' => "Perjalanan baru dari {$event->perjalanan->user->nama} menunggu persetujuan."],
            ]);
        }
    }
}
