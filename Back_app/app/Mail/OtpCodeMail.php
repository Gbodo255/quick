<?php

namespace App\Mail;

use App\Models\CreditApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CreditApplication $application,
        public string $code,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Code de vérification — '.config('credit.brand'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.otp-code',
        );
    }
}
