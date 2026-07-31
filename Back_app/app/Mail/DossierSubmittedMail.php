<?php

namespace App\Mail;

use App\Models\CreditApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DossierSubmittedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public CreditApplication $application,
        public ?string $pdfPath = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Confirmation de soumission — '.config('credit.brand'),
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'mail.dossier-submitted',
        );
    }

    public function attachments(): array
    {
        if ($this->pdfPath && file_exists($this->pdfPath)) {
            return [
                Attachment::fromPath($this->pdfPath)
                    ->as("recapitulatif-{$this->application->reference}.pdf")
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
