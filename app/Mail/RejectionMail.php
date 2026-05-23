<?php

namespace App\Mail;

use App\Models\Attendee;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RejectionMail extends Mailable
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
            subject: 'Informasi Pendaftaran: ' . $this->attendee->event->name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.rejection-mail',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
