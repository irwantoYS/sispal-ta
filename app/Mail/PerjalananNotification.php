<?php

namespace App\Mail;

use App\Models\LaporanPerjalanan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PerjalananNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $perjalanan;
    public $status;
    public $recipient;

    public function __construct(LaporanPerjalanan $perjalanan, $status, User $recipient)
    {
        $this->perjalanan = $perjalanan;
        $this->status = $status;
        $this->recipient = $recipient;
    }

    public function envelope(): Envelope
    {
        $subject = '';
        if ($this->status == 'baru') {
            $subject = "Permintaan Perjalanan Baru dari {$this->perjalanan->user->nama}";
        } elseif ($this->status == 'disetujui') {
            $subject = "Perjalanan Anda Disetujui";
        } elseif ($this->status == 'ditolak') {
            $subject = "Perjalanan Anda Ditolak";
        }

        return new Envelope(
           subject: $subject,
            to:[$this->recipient->email],
             from: new \Illuminate\Mail\Mailables\Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME')),
        );
    }

    public function content(): Content { return new Content(view: 'emails.perjalanan_notification'); }
    public function attachments(): array { return []; }
}
