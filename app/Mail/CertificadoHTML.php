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
    public ?string $subject;
    public ?string $from;
    public ?string $from_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        array $mensaje,
        ?string $pdfContent = null,
        ?string $pdfFilename = 'certificado.pdf',
        ?string $pdfStoragePath = null,
        ?string $subject = null,
        ?string $from = null,
        ?string $from_name = null
    ) {
        $this->mensaje         = $mensaje;
        $this->pdfContent      = $pdfContent;
        $this->pdfFilename     = $pdfFilename;
        $this->pdfStoragePath  = $pdfStoragePath;
        $this->subject         = $subject;
        $this->from            = $from;
        $this->from_name       = $from_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from($this->from, $this->from_name)
            ->subject($this->subject)
            ->view('emails.certificado.html')
            ->with($this->mensaje);

        // Adjuntar el PDF (elegí UNO de los dos enfoques):
        if ($this->pdfContent) { // ✅ SOLO una vía
            $email->attachData($this->pdfContent, $this->pdfFilename, [
                'mime' => 'application/pdf',
            ]);
        } elseif ($this->pdfStoragePath) {
            $email->attach($this->pdfStoragePath, [
                'as'   => $this->pdfFilename,
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}
