<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CertificadoHTML extends Mailable
{
    use Queueable, SerializesModels;

    public array $mensaje;
    protected ?string $pdfContent;
    protected ?string $pdfFilename;
    protected ?string $pdfStoragePath;

    // 👉 NO usar $from / $subject (colisionan con Mailable)
    protected ?string $fromAddress;
    protected ?string $fromName;
    protected ?string $mailSubject;

    public function __construct(
        array $mensaje,
        ?string $pdfContent = null,
        ?string $pdfFilename = 'certificado.pdf',
        ?string $pdfStoragePath = null,
        ?string $mailSubject = null,
        ?string $fromAddress = null,
        ?string $fromName = null
    ) {
        $this->mensaje        = $mensaje;
        $this->pdfContent     = $pdfContent;
        $this->pdfFilename    = $pdfFilename;
        $this->pdfStoragePath = $pdfStoragePath;

        $this->mailSubject = $mailSubject;
        $this->fromAddress = $fromAddress;
        $this->fromName    = $fromName;
    }

    public function build()
    {
        $fromAddress = $this->fromAddress ?: config('mail.from.address');
        $fromName    = $this->fromName    ?: config('mail.from.name');
        $subject     = $this->mailSubject ?: 'Tu certificado';

        $email = $this->from($fromAddress, $fromName)
            ->subject($subject)
            ->view('emails.certificado.html')
            ->with($this->mensaje);

        if ($this->pdfContent) {
            $email->attachData($this->pdfContent, $this->pdfFilename, ['mime' => 'application/pdf']);
        } elseif ($this->pdfStoragePath) {
            $email->attach($this->pdfStoragePath, ['as' => $this->pdfFilename, 'mime' => 'application/pdf']);
        }

        return $email;
    }
}
