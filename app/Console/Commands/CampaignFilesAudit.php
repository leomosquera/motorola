<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CampaignFile;

class CampaignFilesAudit extends Command
{
    ####################################
    #🧠 Qué te cubre este comando
    ####################################
    # ✔ Detecta envíos duplicados reales
    # ✔ Detecta DB optimista / crash intermedio
    # ✔ Detecta errores históricos
    # ✔ No toca DB
    # ✔ No depende de estado actual
    # ✔ Funciona incluso meses después

    protected $signature = 'campaign:files-audit
        {--day= : Auditar un día puntual (YYYY-MM-DD)}
        {--month= : Auditar un mes (YYYY-MM)}
        {--duplicates : Mostrar solo duplicados}';

    protected $description = 'Audita envíos de archivos de campaña cruzando DB y logs SFTP';

    private string $logPath;

    public function __construct()
    {
        parent::__construct();
        $this->logPath = storage_path('logs/campaign-files.log');
    }

    public function handle()
    {
        if (!file_exists($this->logPath)) {
            $this->error('❌ No existe el log campaign-files.log');
            return Command::FAILURE;
        }

        $logs = $this->parseLog();

        if (empty($logs)) {
            $this->warn('⚠ El log está vacío');
            return Command::SUCCESS;
        }

        $logs = $this->filterLogs($logs);

        $this->info('📊 Iniciando auditoría de envíos...');
        $this->line('');

        $this->auditDuplicates($logs);

        if (!$this->option('duplicates')) {
            $this->auditDbVsLog($logs);
            $this->auditErrors($logs);
        }

        $this->info("\n✔ Auditoría finalizada");
        return Command::SUCCESS;
    }

    /* ======================================================
     *  LOG PARSER
     * ====================================================== */

    private function parseLog(): array
    {
        $rows = file($this->logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $data = [];

        foreach ($rows as $line) {
            $json = json_decode($line, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data[] = $json;
            }
        }

        return $data;
    }

    private function filterLogs(array $logs): array
    {
        if ($day = $this->option('day')) {
            return array_filter($logs, fn ($l) => ($l['day'] ?? null) === $day);
        }

        if ($month = $this->option('month')) {
            return array_filter($logs, fn ($l) => str_starts_with($l['day'] ?? '', $month));
        }

        return $logs;
    }

    /* ======================================================
     *  AUDITS
     * ====================================================== */

    private function auditDuplicates(array $logs): void
    {
        $this->info('🔍 Buscando duplicados...');

        $grouped = [];

        foreach ($logs as $log) {
            if (($log['status'] ?? '') !== 'sent') {
                continue;
            }

            $key = ($log['day'] ?? 'unknown')
                .'|'.($log['file_id'] ?? '0')
                .'|'.($log['type'] ?? 'unknown');

            $grouped[$key][] = $log;
        }

        $found = false;

        foreach ($grouped as $key => $items) {
            if (count($items) > 1) {
                $found = true;
                [$day, $fileId, $type] = explode('|', $key);

                $this->warn("⚠ DUPLICADO");
                $this->line("  Día: {$day}");
                $this->line("  File ID: {$fileId}");
                $this->line("  Tipo: {$type}");
                $this->line("  Veces enviado: ".count($items));
                $this->line('');
            }
        }

        if (!$found) {
            $this->info('✔ No se encontraron duplicados');
        }
    }

    private function auditDbVsLog(array $logs): void
    {
        $this->info("\n🔄 Verificando consistencia DB ↔ LOG...");

        $sentFromLog = [];

        foreach ($logs as $log) {
            if (($log['status'] ?? '') === 'sent') {
                $sentFromLog[$log['file_id']] = true;
            }
        }

        $files = CampaignFile::whereIn('status', ['generated', 'sent'])->get();

        foreach ($files as $file) {

            // DB dice sent pero no hay log
            if ($file->status === 'sent' && empty($sentFromLog[$file->id])) {
                $this->error("❌ DB sent sin log → File ID {$file->id} ({$file->day})");
            }

            // Log dice enviado pero DB sigue generated
            if ($file->status === 'generated' && !empty($sentFromLog[$file->id])) {
                $this->warn("⚠ LOG sent pero DB generated → File ID {$file->id} ({$file->day})");
            }
        }
    }

    private function auditErrors(array $logs): void
    {
        $this->info("\n❌ Revisando errores registrados...");

        $errors = array_filter($logs, fn ($l) => ($l['status'] ?? '') === 'error');

        if (empty($errors)) {
            $this->info('✔ No hay errores en el log');
            return;
        }

        foreach ($errors as $e) {
            $this->line("❌ {$e['day']} | {$e['type']} | {$e['error']}");
        }
    }
}
