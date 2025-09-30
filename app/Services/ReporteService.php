<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use App\Models\CampaignLog;
use App\Models\Assurant\Provincia;
use App\Models\Celular;
use App\Models\Assurant\EstadoCivil;

class ReporteService
{
    private function getProduct($params, $services)
    {
        $product = null;  // en vez de false
        if ($params->codarticulo->value != null) {
            foreach ($services->products->data as $item) {
                if ($params->codarticulo->value == $item->code) {
                    $product = $item;
                    break;
                }
            }
        }
        return $product;
    }

    /**
     * Genera un Excel donde cada hoja corresponde al último registro
     * de un evento determinado para el id_log dado.
     * Devuelve la ruta física del archivo generado.
     */
    public function generateExcel(string $idLog, array $eventos = []): string
    {
        // Si no te pasan eventos, definí los que quieras consultar
        if (empty($eventos)) {
            $eventos = [
                'cotizar',
                'datos producto',
                'datos personales',
                'datos terminos',
                'medio de pago'
            ];
        }

        $spreadsheet = new Spreadsheet();

        // 1️⃣ eliminamos la hoja por defecto (en blanco)
        $spreadsheet->removeSheetByIndex(0);

        foreach ($eventos as $evento) {

            // Buscamos el último registro para ese evento
            $log = CampaignLog::where('id_log', $idLog)
                ->where('event', $evento)
                ->latest('id')
                ->with('store')
                ->first();

            if (!$log) {
                // si no hay registro, podés decidir saltar o crear hoja vacía
                continue;
            }

            // tarjetas (lo dejé igual)
            $CC_INFO = [
                'AE' => ['code' => '19'],
                'VI' => ['code' => '13'],
                'MC' => ['code' => '14'],
                'TN' => ['code' => '15'],
                'CA' => ['code' => '16'],
            ];

            // Datos que quieras mostrar en columnas
            $params   = json_decode($log->params);
            $services = json_decode($log->services);

            // Get Producto
            $product = self::getProduct($params, $services);

            // Get Producto

            $prov_data    = Provincia::where('cod', $params->provincia->value)->first() ?? false;
            $celular_data = Celular::where('code', $params->codarticulo->value)->first() ?? false;
            $estado_civil = EstadoCivil::where('cod', $params->estadocivil->value)->first() ?? false;

            $row = [
                'Id_Log'              => $log->id_log,
                'Evento'              => $log->event,
                'Evento_Fecha'        => $log->created_at->format('d/m/Y H:i:s'),
                'Producto_Modelo'     => ($product && isset($product->name)) ? substr(preg_replace('/\s+/', ' ', $product->name), 0, 50) : '',
                'Producto_Version'    => ($product && isset($product->version)) ? substr(preg_replace('/\s+/', ' ', $product->version), 0, 100) : '',
                'Producto_Precio'     => ($product && isset($product->precio_bruto_equipo)) ? number_format($product->precio_bruto_equipo, 2, ',', '.'): '',
                'Cobertura'           => ($product && isset($product->cobertura)) ? substr(preg_replace('/\s+/', ' ', $product->cobertura), 0, 50) : '',
                'Cobertura_Precio'    => ($product && isset($product->precio_seguro)) ? number_format($product->precio_seguro, 2, ',', '.'): '',
                'Tienda_Code'         => $log->store->code ?? '',
                'Tienda_Nombre'       => $log->store->name ?? '',
                'Nombre'              => ($params && isset($params->nombres->value)) ? substr(preg_replace('/\s+/', ' ', $params->nombres->value), 0, 50) : '',
                'Apellido'            => ($params && isset($params->apellidos->value)) ? substr(preg_replace('/\s+/', ' ', $params->apellidos->value), 0, 50) : '',
                'Documento'           => ($params && isset($params->tndoc->value)) ? $params->tndoc->value : '',
                'Cuit'                => ($params && isset($params->tncuit->value)) ? $params->tncuit->value : '',
                'Fecha_Nac'           => ($params && isset($params->fnac->value)) ? substr($params->fnac->value, 0, 2).'/'.substr($params->fnac->value, 3, 2).'/'.substr($params->fnac->value, 6, 4) : '',
                'Sexo'                => ($params && isset($params->sexo->value)) ? $params->sexo->value : '',
                'Estado_Civil'        => $estado_civil ? $estado_civil->desc : '',
                'Ocupacion'           => ($params && isset($params->ocupacion->value)) ? $params->ocupacion->value : '',
                'PTel'                => ($params && isset($params->ptel->value)) ? $params->ptel->value : '',
                'Telefono'            => ($params && isset($params->tel->value)) ? $params->tel->value : '',
                'Email'               => ($params && isset($params->email->value)) ? substr(preg_replace('/\s+/', ' ', $params->email->value), 0, 60) : '',
                'Imei'                => ($params && isset($params->imei->value)) ? substr(preg_replace('/\s+/', ' ', $params->imei->value), 0, 20) : '',
                'Dir_Calle'           => ($params && isset($params->calle->value)) ? substr(preg_replace('/\s+/', ' ', $params->calle->value), 0, 50) : '',
                'Dir_Calle_Nro'       => ($params && isset($params->callenro->value)) ? substr(preg_replace('/\s+/', ' ', $params->callenro->value), 0, 50) : '',
                'Dir_Piso'            => ($params && isset($params->piso->value)) ? substr(preg_replace('/\s+/', ' ', $params->piso->value), 0, 50) : '',
                'Dir_Depto'           => ($params && isset($params->dto->value)) ? substr(preg_replace('/\s+/', ' ', $params->dto->value), 0, 50) : '',
                'Dir_Cod_Postal'      => ($params && isset($params->cp->value)) ? substr(preg_replace('/\s+/', ' ', $params->cp->value), 0, 25) : '',
                'Dir_Localidad'       => ($params && isset($params->localidad->value)) ? substr(preg_replace('/\s+/', ' ', $params->localidad->value), 0, 100) : '',
                'Pers_Politic'        => ($params && isset($params->pers->value)) ? $params->pers->value : '',
                'Pers_SO'             => ($params && isset($params->sujetoso->value)) ? $params->sujetoso->value : 'NO',
                'Term_Cond'           => ($params && isset($params->terms_conds->value) && $params->terms_conds->value == 1) ? 'SI' : 'NO',
                'Term_File_Version'   => ($params && isset($params->terms_version->value)) ? $params->terms_version->value : '',
                'Emails_Promocion'    => ($params && isset($params->newsletter->value) && $params->newsletter->value == 1) ? 'SI' : 'NO',
                'Medio_Pago'          => ($params && isset($params->mpago->value)) ? $params->mpago->value : '',
                'CC_Nombre'           => ($params && isset($params->tnombres->value)) ? substr(preg_replace('/\s+/', ' ', $params->tnombres->value), 0, 50) : '',
                'CC_Nro'              => ($params && isset($params->ntarjeta->value)) ? $params->ntarjeta->value : '',
                'CC_CVV'              => ($params && isset($params->tcvv->value)) ? $params->tcvv->value : '',
                'CC_Type'             => ($params && isset($params->tcctype->value)) ? $CC_INFO[$params->tcctype->value]['code'] : '',
                'CC_Fecha_Venc'       => ($params && isset($params->ftarjeta->value)) ? substr($params->ftarjeta->value, 0, 2).'20'.substr($params->ftarjeta->value, 3, 2) : '',
                'Email_Enviado'       => ($log->send_mail == 1) ? 'SI' : 'NO',
                'Fecha_Venta'         => ($params && isset($params->fventa->value)) ?str_replace(['/','-'], ['',''], $params->fventa->value) : '',
                'File'                => $log->file ?? '',
                'IP'                  => $log->ip_info ?? '',
                // …agregá los campos que necesites
            ];

            // Creamos la hoja con el nombre del evento
            $sheet = $spreadsheet->createSheet();
            // los nombres de hoja no pueden superar 31 caracteres
            $sheet->setTitle(substr($evento, 0, 31));

            // ✅ Escribimos títulos (encabezados)
            $rowNumber = 1;
            $colIndex  = 1;
            foreach (array_keys($row) as $titulo) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex); // 1 => A, 2 => B...
                $sheet->setCellValue($colLetter.$rowNumber, $titulo);
                $colIndex++;
            }

            // ✅ Escribimos los valores en la fila 2
            $rowNumber = 2;
            $colIndex  = 1;
            foreach (array_values($row) as $valor) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue($colLetter.$rowNumber, $valor);
                $colIndex++;
            }
        }

        // Guardamos en storage/app/temp
        $fileName = 'log_'.$idLog.'.xlsx';
        $path = storage_path('app/temp/'.$fileName);
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return $path; // listo para agregar al ZIP
    }
}