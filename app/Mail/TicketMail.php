<?php

namespace App\Mail;

use App\Models\Attendee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $attendee;

    public function __construct(Attendee $attendee)
    {
        $this->attendee = $attendee;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tiket Digital Anda: ' . $this->attendee->event->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket-mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
