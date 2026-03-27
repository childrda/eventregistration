<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $htmlBody = '',
        public string $textBody = '',
        public ?string $fromName = null,
        public ?string $replyToEmail = null,
    ) {
    }

    public function envelope(): Envelope
    {
        $envelope = new Envelope(subject: $this->subjectLine);

        if ($this->replyToEmail) {
            $envelope->replyTo = [$this->replyToEmail];
        }

        return $envelope;
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.registration_confirmation',
            with: [
                'htmlBody' => $this->htmlBody,
                'textBody' => $this->textBody,
            ],
        );
    }
}

