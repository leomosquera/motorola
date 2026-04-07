<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Services\ReporteService;
use App\Services\TerminosService;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Models\CampaignLog;
use App\Models\CampaignFile;
use App\Models\Celular;
use App\Models\Assurant\Provincia;

class CampaignGenerateFiles extends Command
{
    protected $signature = 'campaign:generate-files 
        {--day= : Procesar un día específico (YYYY-MM-DD)}
        {--range : Procesar rango según config.subdays}
        {--force : Sobrescribir archivos existentes}
        {--include-today : Incluir hoy}';

    protected $description = 'Genera archivos TXT y ZIP para la campaña (formato Assurant).';

    public function handle()
    {
        $includeToday = $this->option('include-today');
        $force        = $this->option('force');

        $dealer_code = 'MO13';
        $baseDir     = config('global.storage.files');

        /* =========================
         * 1️⃣ Definir días a procesar
         * ========================= */
        $days = [];

        if ($this->option('day')) {

            $days[] = Carbon::createFromFormat('Y-m-d', $this->option('day'));

        } elseif ($this->option('range')) {

            $subdays = max(1, (int) config('global.log.subdays', 1));

            for ($d = 0; $d < $subdays; $d++) {
                $days[] = Carbon::today()->subDays($d);
            }

        } else {

            // 👉 default = AYER (modo cron seguro)
            $days[] = Carbon::yesterday();
        }

        /* =========================
         * 2️⃣ Loop de días
         * ========================= */
        foreach ($days as $day) {

            $this->info("📅 Procesando: ".$day->format('Y-m-d'));

            if ($day->isToday() && !$includeToday) {
                $this->warn("⚠ Se omite hoy (usar --include-today)");
                continue;
            }

            // 🔒 NO pisar enviados
            $existing = CampaignFile::where('day', $day->format('Y-m-d'))->first();

            if ($existing && !$force) {
                $this->warn("⚠ Día {$day->format('Y-m-d')} ya fue procesado. Se omite (usar --force para regenerar).");
                continue;
            }

            $from = $day->copy()->startOfDay();
            $to   = $day->copy()->endOfDay();

            $txtName  = "AMA_{$dealer_code}_ENROLLMENT_MOTO_NV_".$day->format('Ymd').".txt";
            $zipName  = pathinfo($txtName, PATHINFO_FILENAME).'.zip';

            $relativeTxt = $baseDir . $txtName;
            $relativeZip = $baseDir . $zipName;

            $absoluteZip = storage_path("app/{$relativeZip}");

            /* =========================
             * 3️⃣ Limpieza (solo si force)
             * ========================= */
            if ($force) {
                Storage::delete([$relativeTxt, $relativeZip]);

                CampaignLog::where('payment_code', 'CC')
                    ->where('event', 'medio de pago')
                    ->whereBetween('created_at', [$from, $to])
                    ->update([
                        'file' => null,
                        'payment_verified' => 0,
                    ]);
            }

            /* =========================
             * 4️⃣ Obtener logs
             * ========================= */
            $query = CampaignLog::where('payment_code', 'CC')
                ->where('event', 'medio de pago')
                ->whereBetween('created_at', [$from, $to])
                ->orderBy('id')
                ->with('store');

            if (!$force) {
                $query->whereNull('file');
            }

            $logs = $query->get();
            $log_count = $logs->count();

            $logsProcesados = [];

            /* =========================
             * 5️⃣ Generar TXT (líneas)
             * ========================= */
            foreach ($logs as $log) {

                $params   = json_decode($log->params);
                $services = json_decode($log->services);

                foreach ($services->products->data as $product) {

                    if ($params->codarticulo->value != $product->code) {
                        continue;
                    }

                    $prov_data    = Provincia::where('cod', $params->provincia->value)->first();
                    $celular_data = Celular::where('code', $params->codarticulo->value)->first();

                    // Armar línea TXT
                    $txt  = 'FC¦¦¦';
                    $txt .= $product->precio_bruto_equipo.'¦0¦12¦';
                    $txt .= $product->precio_seguro.'¦¦¦';
                    $txt .= $log->store->code.'¦';
                    $txt .= $log->id.'¦';
                    $txt .= str_replace(['/','-'], ['',''], $params->fventa->value).'¦';
                    $txt .= '¦'.$params->tndoc->value.'¦';
                    $txt .= substr(trim($params->nombres->value.' '.$params->apellidos->value), 0, 50).'¦';
                    $txt .= substr(trim($params->email->value), 0, 50).'¦';
                    $txt .= substr(trim($params->calle->value.' '.$params->callenro->value.' '.$params->piso->value.' '.$params->dto->value), 0, 50).'¦';
                    $txt .= $params->sujetoso->value.'¦';
                    $txt .= substr(trim($params->localidad->value), 0, 50).'¦';
                    $txt .= substr(trim($params->cp->value), 0, 25).'¦';
                    $txt .= substr(trim($prov_data->branch_code ?? ''), 0, 50).'¦';
                    $txt .= substr(trim($params->tel->value), 0, 15).'¦';
                    $txt .= '¦AR¦AR¦ARS¦';
                    $txt .= $day->format('dmY').'¦';
                    $txt .= ($celular_data->elita ?? '').'¦6¦MOTOROLA¦';
                    $txt .= substr(trim($product->version), 0, 30).'¦';
                    $txt .= substr($params->imei->value, 0, 20).'¦1¦12¦';
                    $txt .= $product->precio_seguro.'¦C¦¦¦';
                    $txt .= substr(trim($params->tnombres->value), 0, 50).'¦';
                    $txt .= $params->tcctype->value.'¦';
                    $txt .= $params->ntarjeta->value.'¦';
                    $txt .= substr($params->ftarjeta->value, 0, 2).'20'.substr($params->ftarjeta->value, 3, 2).'¦';
                    $txt .= str_repeat('¦', 80);
                    $txt .= substr($params->sexo->value, 0, 1).'¦';
                    $txt .= substr($params->fnac->value, 6, 4).substr($params->fnac->value, 3, 2).substr($params->fnac->value, 0, 2).'¦';
                    $txt .= $params->estadocivil->value.'¦AR¦AR¦';
                    $txt .= $params->tncuit->value.'¦';
                    $txt .= $params->imei->value.'¦';
                    $txt .= $params->ocupacion->value.'¦';

                    Storage::append($relativeTxt, Helper::utf8toansi($txt));

                    $log->file = $txtName;
                    $log->payment_verified = 1;
                    $log->save();

                    $logsProcesados[] = [
                        'id_log' => $log->id_log,
                        'id'     => $log->id
                    ];

                    break;
                }
            }

            /* =========================
             * 6️⃣ Header SIEMPRE
             * ========================= */
            if (!Storage::exists($relativeTxt)) {
                Storage::put($relativeTxt, '');
            }

            $header = 'HH¦'.$dealer_code.'¦'.$day->format('Ymd').'¦'.$log_count.'¦';
            Storage::prepend($relativeTxt, Helper::utf8toansi($header));

            /* =========================
             * 7️⃣ ZIP (siempre)
             * ========================= */
            $zip = new ZipArchive();

            if ($zip->open($absoluteZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {

                if (!empty($logsProcesados)) {

                    foreach ($logsProcesados as $logData) {

                        $folderName = $logData['id'].'-log_'.$logData['id_log'].'/';

                        $zip->addEmptyDir($folderName);

                        $excelPath = app(ReporteService::class)->generateExcel($logData['id_log'], $logData['id']);
                        $pdfPath   = app(TerminosService::class)->generatePdf($logData['id_log'], $logData['id']);

                        $zip->addFile($excelPath, $folderName.basename($excelPath));
                        $zip->addFile($pdfPath,   $folderName.basename($pdfPath));
                    }

                } else {

                    // Excel vacío con headers
                    $emptyExcelPath = app(ReporteService::class)->generateEmptyExcel($day);

                    $zip->addFile($emptyExcelPath, basename($emptyExcelPath));
                }

                $zip->close();
            } else {
                throw new \Exception("No se pudo crear el ZIP: {$absoluteZip}");
            }

            /* =========================
             * 8️⃣ Registrar
             * ========================= */
            CampaignFile::updateOrCreate(
                [
                    'day' => $day->format('Y-m-d'),
                    'txt_name' => $txtName,
                ],
                [
                    'zip_name' => $zipName,
                    'txt_path' => $relativeTxt,
                    'zip_path' => $relativeZip,
                    'status'   => 'generated'
                ]
            );

            $this->info("✔ Generado: {$txtName} ({$log_count} registros)");
        }

        $this->info("🚀 Proceso completado.");
        return Command::SUCCESS;
    }
}