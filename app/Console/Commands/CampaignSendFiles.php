<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CampaignFile;
use Storage;

class CampaignSendFiles extends Command
{
    protected $signature = 'campaign:send-files';
    protected $description = 'Envía por SFTP los archivos TXT y ZIP generados para campaña.';

    // 🔐 Configuración de SFTP (migrable a .env)
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

                // 2️⃣ Autenticación con clave pública/privada
                if (!ssh2_auth_pubkey_file(
                    $connection,
                    $this->username,
                    "{$this->privateKey}.pub",
                    $this->privateKey
                )) {
                    throw new \Exception("Error de autenticación SSH.");
                }

                // 3️⃣ Iniciar sesión SFTP
                $sftp = ssh2_sftp($connection);
                if (!$sftp) {
                    throw new \Exception("No se pudo iniciar la sesión SFTP.");
                }

                // -----------------------
                // 4️⃣ Enviar el TXT primero
                // -----------------------
				$this->info("📤 Enviando archivo: {$file->txt_name}");
                $localTxt = storage_path("app/{$file->txt_path}");
				$this->sendFile($sftp, $localTxt, "/ToAssurantEFT/{$file->txt_name}");
				$this->info("✔ TXT enviado: {$file->txt_name}");
				
                // -----------------------
                // 5️⃣ Enviar ZIP después
                // -----------------------
				$this->info("📤 Enviando archivo: {$file->zip_path}");
                $localZip = storage_path("app/{$file->zip_path}");
				$this->sendFile($sftp, $localZip, "/ToAssurantEFT/{$file->zip_name}");
				$this->info("✔ ZIP enviado: {$file->zip_name}");

                // 6️⃣ Marcar como enviado
                $file->update([
                    'status'        => 'sent',
                    'sent_at'       => now(),
                    'error_message' => null,
                ]);


            } catch (\Exception $e) {

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
     * Enviar archivo por SFTP usando SSH2
     *
     * @param $sftp        recurso SFTP
     * @param string $relativePath  ↿path relativo "files/XXX"
     */
    private function sendFile($sftp, $localFile, $remoteFile)
	{
		if (!file_exists($localFile)) {
			throw new \Exception("El archivo local no existe: $localFile");
		}

		$stream = @fopen("ssh2.sftp://{$sftp}{$remoteFile}", 'w');

		if (!$stream) {
			throw new \Exception("No se pudo abrir el archivo remoto: $remoteFile");
		}

		$local = fopen($localFile, 'r');

		if (!$local) {
			fclose($stream);
			throw new \Exception("No se pudo abrir el archivo local: $localFile");
		}

		while (!feof($local)) {
			if (fwrite($stream, fread($local, 8192)) === false) {
				throw new \Exception("Error escribiendo en archivo remoto: $remoteFile");
			}
		}

		fclose($local);
		fclose($stream);
	}

}
