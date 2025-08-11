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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        array $mensaje,
        ?string $pdfContent = null,
        ?string $pdfFilename = 'certificado.pdf',
        ?string $pdfStoragePath = null
    ) {
        $this->mensaje         = $mensaje;
        $this->pdfContent      = $pdfContent;
        $this->pdfFilename     = $pdfFilename;
        $this->pdfStoragePath  = $pdfStoragePath;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->from('no-reply@kopernicus.tech', 'Protección Motocare')
            ->subject('¡Gracias! Hemos recibido tu solicitud de compra')
            ->view('emails.certificado.html')
            ->with($this->mensaje);

        // Adjuntar el PDF (elegí UNO de los dos enfoques):

        // A) Adjuntar desde binario en memoria:
        if ($this->pdfContent) {
            $email->attachData($this->pdfContent, $this->pdfFilename, [
                'mime' => 'application/pdf'
            ]);
        }

        // B) Adjuntar desde archivo en storage:
        if ($this->pdfStoragePath) {
            $email->attach($this->pdfStoragePath, [
                'as'   => $this->pdfFilename,
                'mime' => 'application/pdf'
            ]);
        }

        return $email;
    }
}
