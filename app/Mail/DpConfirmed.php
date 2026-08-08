<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DpConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Down Payment & Undangan Grup WA - Travelingin.id',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.dp_confirmed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
