<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\CampaignFile;
use Illuminate\Support\Facades\Artisan;

class CampaignRegenDay extends Command
{
    protected $signature = 'campaign:regen-day 
        {day : Fecha a reprocesar (YYYY-MM-DD)} 
        {--include-today}';

    # Modos de uso    
    # Reprocesar un día viejo
    # php artisan campaign:regen-day 2026-01-10

    # Reprocesar hoy (solo si estás seguro)
    # php artisan campaign:regen-day 2026-01-23 --include-today

    # Luego reenviar
    # php artisan campaign:send-files

    protected $description = 'Regenera los archivos de un día específico y los deja listos para reenvío';

    public function handle()
    {
        $dayInput = $this->argument('day');

        try {
            $day = Carbon::createFromFormat('Y-m-d', $dayInput)->startOfDay();
        } catch (\Exception $e) {
            $this->error('❌ Formato de fecha inválido. Use YYYY-MM-DD');
            return Command::FAILURE;
        }

        if ($day->isToday() && !$this->option('include-today')) {
            $this->error('⚠ No se puede reprocesar hoy sin --include-today');
            return Command::FAILURE;
        }

        $this->info("♻ Reprocesando campaña del día {$day->format('Y-m-d')}");

        // 1️⃣ Limpiar estado previo
        CampaignFile::where('day', $day->format('Y-m-d'))->update([
            'status'        => 'generated',
            'sent_at'       => null,
            'error_message' => null,
        ]);

        // 2️⃣ Ejecutar generator en modo force SOLO ese día
        config([
            'global.log.subdays' => 1,
        ]);

        Carbon::setTestNow($day);

        Artisan::call('campaign:generate-files', [
            '--force' => true,
            '--include-today' => true,
        ]);

        Carbon::setTestNow(); // reset

        $this->info("✔ Día {$day->format('Y-m-d')} regenerado y listo para envío");
        $this->info("👉 Ejecutar: php artisan campaign:send-files");

        return Command::SUCCESS;
    }
}
