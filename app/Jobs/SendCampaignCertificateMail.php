<?php

namespace App\Jobs;

use App\Models\CampaignLog;
use App\Services\CertificadoService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\EmailParams;
use MailerSend\Helpers\Builder\Attachment as MsAttachment;

class SendCampaignCertificateMail
{
    protected int $campaignLogId;

    public function __construct(int $campaignLogId)
    {
        $this->campaignLogId = $campaignLogId;
    }

    private static function sendmail(){
        return config('enviroment.sendmail');
    }

    public function handle(): void
    {

        Log::channel('mailersend')->info('JOB EXECUTED', [
            'campaign_log_id' => $this->campaignLogId
        ]);

        $campaignlog = CampaignLog::find($this->campaignLogId);

        Log::channel('mailersend')->info('JOB START', [
            'campaign_log_id' => $campaignlog->id
        ]);

        if (!$campaignlog) {
            Log::channel('mailersend')->error('CampaignLog NOT FOUND', [
                'campaign_log_id' => $this->campaignLogId
            ]);
            return;
        }

        try {

            /* ============================
             * DATOS BASE
             * ============================ */
            $params = json_decode($campaignlog->params, true);

            $emailTo = $params['email']['value'] ?? null;

            if (!$emailTo || !filter_var($emailTo, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid TO email');
            }

            /* ============================
             * DATA PARA PDF / MAIL
             * ============================ */
            $certificadoService = app(CertificadoService::class);
            $data = $certificadoService->buildData($campaignlog);

            /* ============================
             * GENERAR PDF
             * ============================ */
            $pdfContent = $certificadoService->generatePdf($data);

            $filename = 'Solicitud-de-compra-' . date('YmdHis') . '.pdf';
            $path     = 'certificados/' . $filename;

            Storage::put($path, $pdfContent);

            /* ============================
             * MAILERSEND CONFIG
             * ============================ */
            $cfg = self::sendmail()['mailersend']['proteccion-motocare'];

            $from      = $cfg['from'];
            $bccRaw    = $cfg['bcc'] ?? null;
            $token     = $cfg['type'] === 'prod' ? $cfg['token_prod'] : $cfg['token_dev'];
            $fromName  = 'Protección Motocare';
            $subject   = '¡Gracias! Hemos recibido tu solicitud de compra';

            Log::channel('mailersend')->info('MailerSend INIT', [
                'campaign_log_id' => $campaignlog->id,
                'to'              => $emailTo,
                'from'            => $from,
                'bcc_raw'         => $bccRaw,
                'pdf'             => $path,
            ]);

            $ms = new MailerSend([
                'api_key' => $token
            ]);

            /* ============================
             * HTML MAIL
             * ============================ */
            $html = view('emails.certificado.html', $data)->render();

            $to = [
                new Recipient($emailTo, '')
            ];

            $bcc = [];
            if (!empty($bccRaw) && filter_var($bccRaw, FILTER_VALIDATE_EMAIL)) {
                $bcc[] = new Recipient($bccRaw, '');
            }

            $attachments = [
                new MsAttachment($pdfContent, $filename)
            ];

            $email = (new EmailParams())
                ->setFrom($from)
                ->setFromName($fromName)
                ->setRecipients($to)
                ->setSubject($subject)
                ->setHtml($html)
                ->setAttachments($attachments);

            if (!empty($bcc)) {
                $email->setBcc($bcc);
            }

            /* ============================
             * SEND
             * ============================ */
            $response = $ms->email->send($email);

            Log::channel('mailersend')->info('MailerSend RESPONSE', [
                'campaign_log_id' => $campaignlog->id,
                'response'        => $response,
            ]);

            if (is_array($response) && isset($response['status_code']) && $response['status_code'] !== 202) {
                throw new \Exception('MailerSend status != 202');
            }

            /* ============================
             * OK
             * ============================ */
            $campaignlog->send_mail = 1;
            $campaignlog->save();

            Log::channel('mailersend')->info('MailerSend OK', [
                'campaign_log_id' => $campaignlog->id,
            ]);

        } catch (\Throwable $e) {

            $campaignlog->send_mail = 0;
            $campaignlog->save();

            Log::channel('mailersend')->error('MailerSend ERROR', [
                'campaign_log_id' => $campaignlog->id,
                'message'         => $e->getMessage(),
                'trace'           => $e->getTraceAsString(),
            ]);
        }
    }
}
