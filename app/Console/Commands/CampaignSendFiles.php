<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CampaignFile;
use App\Support\CampaignFileLogger;
use Carbon\Carbon;

class CampaignSendFiles extends Command
{
    protected $signature = 'campaign:send-files';
    protected $description = 'Envía por SFTP los archivos TXT y ZIP generados para campaña.';

    // 🔐 Configuración de SFTP (ideal migrar a .env)
    private $host = 'sftp1.assurant.com';
    private $port = 22;
    private $username = 'gcARkopern01';
    private $privateKey = '/home/koper/storagedir/ssh/id_rsa';

    public function handle()
    {
        $pendientes = CampaignFile::where('status', 'generated')->get();

        if ($pendientes->isEmpty()) {
            $this->info("No hay archivos pendientes para enviar.");
            return Command::SUCCESS;
        }

        foreach ($pendientes as $file) {

            try {

                // 1️⃣ Conectar
                $connection = ssh2_connect($this->host, $this->port, ['hostkey' => 'ssh-rsa']);
                if (!$connection) {
                    throw new \Exception("No se pudo conectar al servidor SSH.");
                }

                // 2️⃣ Autenticación
                if (!ssh2_auth_pubkey_file(
                    $connection,
                    $this->username,
                    "{$this->privateKey}.pub",
                    $this->privateKey
                )) {
                    throw new \Exception("Error de autenticación SSH.");
                }

                // 3️⃣ SFTP
                $sftp = ssh2_sftp($connection);
                if (!$sftp) {
                    throw new \Exception("No se pudo iniciar la sesión SFTP.");
                }

                /* =======================
                 *  TXT
                 * ======================= */
                if ($this->alreadySent($file->id, 'txt')) {

                    $this->warn("⚠ TXT ya enviado (log): {$file->txt_name}");

                } else {

                    $this->info("📤 Enviando archivo: {$file->txt_name}");

                    $localTxt = storage_path("app/{$file->txt_path}");
                    $this->sendFile($sftp, $localTxt, "/ToAssurantEFT/{$file->txt_name}");

                    CampaignFileLogger::log([
                        'day'     => $file->day,
                        'file_id' => $file->id,
                        'type'    => 'txt',
                        'name'    => $file->txt_name,
                        'status'  => 'sent',
                    ]);

                    $this->info("✔ TXT enviado: {$file->txt_name}");
                }

                /* =======================
                 *  ZIP
                 * ======================= */
                if ($this->alreadySent($file->id, 'zip')) {

                    $this->warn("⚠ ZIP ya enviado (log): {$file->zip_name}");

                } else {

                    $this->info("📤 Enviando archivo: {$file->zip_name}");

                    $localZip = storage_path("app/{$file->zip_path}");
                    $this->sendFile($sftp, $localZip, "/ToAssurantEFT/{$file->zip_name}");

                    CampaignFileLogger::log([
                        'day'     => $file->day,
                        'file_id' => $file->id,
                        'type'    => 'zip',
                        'name'    => $file->zip_name,
                        'status'  => 'sent',
                    ]);

                    $this->info("✔ ZIP enviado: {$file->zip_name}");
                }

                // 4️⃣ Marcar como enviado (estado funcional)
                $file->update([
                    'status'        => 'sent',
                    'sent_at'       => Carbon::now(),
                    'error_message' => null,
                ]);

            } catch (\Exception $e) {

                CampaignFileLogger::log([
                    'day'     => $file->day ?? null,
                    'file_id' => $file->id ?? null,
                    'type'    => 'error',
                    'name'    => ($file->txt_name ?? '').' | '.($file->zip_name ?? ''),
                    'status'  => 'error',
                    'error'   => $e->getMessage(),
                ]);

                $file->update([
                    'status'        => 'error',
                    'error_message' => $e->getMessage()
                ]);

                $this->error("❌ Error enviando archivo: {$e->getMessage()}");
            }
        }

        return Command::SUCCESS;
    }

    /**
     * Detecta si el archivo ya fue enviado (leyendo el log)
     */
    private function alreadySent(int $fileId, string $type): bool
    {
        $path = storage_path('logs/campaign-files.log');

        if (!file_exists($path)) {
            return false;
        }

        $needle = '"file_id":'.$fileId.',"type":"'.$type.'","status":"sent"';

        return str_contains(file_get_contents($path), $needle);
    }

    /**
     * Enviar archivo por SFTP usando SSH2
     */
    private function sendFile($sftp, string $localFile, string $remoteFile): void
    {
        if (!file_exists($localFile)) {
            throw new \Exception("El archivo local no existe: {$localFile}");
        }

        $stream = @fopen("ssh2.sftp://{$sftp}{$remoteFile}", 'w');
        if (!$stream) {
            throw new \Exception("No se pudo abrir el archivo remoto: {$remoteFile}");
        }

        $local = fopen($localFile, 'r');
        if (!$local) {
            fclose($stream);
            throw new \Exception("No se pudo abrir el archivo local: {$localFile}");
        }

        while (!feof($local)) {
            if (fwrite($stream, fread($local, 8192)) === false) {
                throw new \Exception("Error escribiendo en archivo remoto: {$remoteFile}");
            }
        }

        fclose($local);
        fclose($stream);
    }
}
