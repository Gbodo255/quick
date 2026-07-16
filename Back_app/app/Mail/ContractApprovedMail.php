<?php

namespace App\Mail;

use App\Models\CreditApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContractApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CreditApplication $application,
        public string $contractPdfPath,
        public ?string $customMessage = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre offre de contrat de prêt — ' . config('credit.brand'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.contract-approved',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromPath($this->contractPdfPath)
                ->as("contrat-{$this->application->reference}.pdf")
                ->withMime('application/pdf'),
        ];
    }
}
