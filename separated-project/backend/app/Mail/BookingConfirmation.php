<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
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
            subject: 'Konfirmasi Pemesanan - Travelingin.id',
        );
    }

    
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.bookings.confirmation',
        );
    }

    
    public function attachments(): array
    {
        return [];
    }
}
