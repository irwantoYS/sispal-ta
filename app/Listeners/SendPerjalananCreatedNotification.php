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
        // Ambil semua pengguna dengan peran 'managerarea' atau 'HSSE'
        $recipients = User::whereIn('role', ['managerarea', 'HSSE'])->get();

        foreach ($recipients as $recipient) {
            // Kirim email notifikasi
            Mail::to($recipient->email)->send(new PerjalananNotification($event->perjalanan, 'baru', $recipient));

            // Buat notifikasi di database
            Notification::create([
                'type' => 'perjalanan_baru',
                'notifiable_type' => get_class($recipient),
                'notifiable_id' => $recipient->id,
                'data' => [
                    'perjalanan_id' => $event->perjalanan->id,
                    'driver' => $event->perjalanan->user->nama,
                    'pesan' => "Perjalanan baru dari {$event->perjalanan->user->nama} menunggu persetujuan."
                ],
            ]);
        }
    }
}
