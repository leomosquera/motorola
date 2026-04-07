<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use App\Models\CampaignLog;
use App\Models\Celular;
use App\Models\Assurant\Provincia;
use App\Models\Assurant\EstadoCivil;
use Carbon\Carbon;

class ReporteService
{

    private function getHeaders(): array
    {
        return [
            'Id_Log',
            'Evento',
            'Evento_Fecha',
            'Producto_Modelo',
            'Producto_Version',
            'Producto_Precio',
            'Cobertura',
            'Cobertura_Precio',
            'Tienda_Code',
            'Tienda_Nombre',
            'Nombre',
            'Apellido',
            'Documento',
            'Cuit',
            'Fecha_Nac',
            'Sexo',
            'Estado_Civil',
            'Ocupacion',
            'PTel',
            'Telefono',
            'Email',
            'Imei',
            'Fecha_Factura_Equipo',
            'Dir_Calle',
            'Dir_Calle_Nro',
            'Dir_Piso',
            'Dir_Depto',
            'Dir_Cod_Postal',
            'Dir_Localidad',
            'Pers_Politic',
            'Pers_SO',
            'Term_Cond',
            'Term_File_Version',
            'Medio_Pago',
            'CC_Nombre',
            'CC_Nro',
            'CC_CVV',
            'CC_Type',
            'CC_Fecha_Venc',
            'Email_Enviado',
            'Fecha_Venta',
            'File',
            'IP',
        ];
    }

    private function getProduct($params, $services)
    {
        $product = null;
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
     * Genera un Excel vacio
     */
    public function generateEmptyExcel($day): string
    {
        $day = $day instanceof Carbon ? $day : Carbon::parse($day);

        $spreadsheet = new Spreadsheet();

        // eliminar hoja default
        $spreadsheet->removeSheetByIndex(0);

        $eventos = [
            'cotizar',
            'datos producto',
            'datos personales',
            'datos terminos',
            'medio de pago'
        ];

        $headers = $this->getHeaders();

        foreach ($eventos as $index => $evento) {

            $sheet = $spreadsheet->createSheet($index);
            $sheet->setTitle(substr($evento, 0, 31));

            $colIndex = 1;

            foreach ($headers as $header) {

                $colLetter = Coordinate::stringFromColumnIndex($colIndex);

                $sheet->setCellValue($colLetter.'1', $header);

                if (in_array($header, ['Telefono', 'Imei', 'Documento', 'Cuit'])) {
                    $sheet->getStyle($colLetter)
                        ->getNumberFormat()
                        ->setFormatCode(NumberFormat::FORMAT_TEXT);
                }

                $colIndex++;
            }
        }

        $fileName = 'empty_'.$day->format('Ymd').'.xlsx';
        $path = storage_path('app/temp/'.$fileName);

        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        $spreadsheet->setActiveSheetIndex(0);

        return $path;
    }

    /**
     * Genera un Excel donde cada hoja corresponde al último registro
     * de un evento determinado para el id_log dado.
     * Devuelve la ruta física del archivo generado.
     */
    public function generateExcel(string $idLog, string $id): string
    {
        // Si no te pasan eventos, definí los que quieras consultar
        $eventos = [
            'cotizar',
            'datos producto',
            'datos personales',
            'datos terminos',
            'medio de pago'
        ];

        $spreadsheet = new Spreadsheet();

        // 1️⃣ eliminamos la hoja por defecto (en blanco)
        $spreadsheet->removeSheetByIndex(0);

        $sheetIndex = 0;

        foreach ($eventos as $evento) {

            // Buscamos el último registro para ese evento
            $log = CampaignLog::where('id_log', $idLog)
                ->where('event', $evento)
                ->latest('id')
                ->with('store')
                ->first();

            if (!$log) {
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
                'Id_Log'               => $log->id_log,
                'Evento'               => $log->event,
                'Evento_Fecha'         => $log->created_at->format('d/m/Y H:i:s'),
                'Producto_Modelo'      => ($product && isset($product->name)) ? substr(preg_replace('/\s+/', ' ', $product->name), 0, 50) : '',
                'Producto_Version'     => ($product && isset($product->version)) ? substr(preg_replace('/\s+/', ' ', $product->version), 0, 100) : '',
                'Producto_Precio'      => ($product && isset($product->precio_bruto_equipo)) ? number_format($product->precio_bruto_equipo, 2, ',', '.'): '',
                'Cobertura'            => ($product && isset($product->cobertura)) ? substr(preg_replace('/\s+/', ' ', $product->cobertura), 0, 50) : '',
                'Cobertura_Precio'     => ($product && isset($product->precio_seguro)) ? number_format($product->precio_seguro, 2, ',', '.'): '',
                'Tienda_Code'          => $log->store->code ?? '',
                'Tienda_Nombre'        => $log->store->name ?? '',
                'Nombre'               => ($params && isset($params->nombres->value)) ? substr(preg_replace('/\s+/', ' ', $params->nombres->value), 0, 50) : '',
                'Apellido'             => ($params && isset($params->apellidos->value)) ? substr(preg_replace('/\s+/', ' ', $params->apellidos->value), 0, 50) : '',
                'Documento'            => ($params && isset($params->tndoc->value)) ? $params->tndoc->value : '',
                'Cuit'                 => ($params && isset($params->tncuit->value)) ? $params->tncuit->value : '',
                'Fecha_Nac'            => ($params && isset($params->fnac->value)) ? substr($params->fnac->value, 0, 2).'/'.substr($params->fnac->value, 3, 2).'/'.substr($params->fnac->value, 6, 4) : '',
                'Sexo'                 => ($params && isset($params->sexo->value)) ? $params->sexo->value : '',
                'Estado_Civil'         => $estado_civil ? $estado_civil->desc : '',
                'Ocupacion'            => ($params && isset($params->ocupacion->value)) ? $params->ocupacion->value : '',
                'PTel'                 => ($params && isset($params->ptel->value)) ? $params->ptel->value : '',
                'Telefono'             => ($params && isset($params->tel->value)) ? $params->tel->value : '',
                'Email'                => ($params && isset($params->email->value)) ? substr(preg_replace('/\s+/', ' ', $params->email->value), 0, 60) : '',
                'Imei'                 => ($params && isset($params->imei->value)) ? substr(preg_replace('/\s+/', ' ', $params->imei->value), 0, 20) : '',
                'Fecha_Factura_Equipo' => ($params && isset($params->fventa->value)) ?str_replace(['/','-'], ['',''], $params->fventa->value) : '',
                'Dir_Calle'            => ($params && isset($params->calle->value)) ? substr(preg_replace('/\s+/', ' ', $params->calle->value), 0, 50) : '',
                'Dir_Calle_Nro'        => ($params && isset($params->callenro->value)) ? substr(preg_replace('/\s+/', ' ', $params->callenro->value), 0, 50) : '',
                'Dir_Piso'             => ($params && isset($params->piso->value)) ? substr(preg_replace('/\s+/', ' ', $params->piso->value), 0, 50) : '',
                'Dir_Depto'            => ($params && isset($params->dto->value)) ? substr(preg_replace('/\s+/', ' ', $params->dto->value), 0, 50) : '',
                'Dir_Cod_Postal'       => ($params && isset($params->cp->value)) ? substr(preg_replace('/\s+/', ' ', $params->cp->value), 0, 25) : '',
                'Dir_Localidad'        => ($params && isset($params->localidad->value)) ? substr(preg_replace('/\s+/', ' ', $params->localidad->value), 0, 100) : '',
                'Pers_Politic'         => ($params && isset($params->pers->value)) ? $params->pers->value : '',
                'Pers_SO'              => ($params && isset($params->sujetoso->value)) ? $params->sujetoso->value : 'NO',
                'Term_Cond'            => ($params && isset($params->terms_conds->value) && $params->terms_conds->value == 1) ? 'SI' : 'NO',
                'Term_File_Version'    => ($params && isset($params->terms_version->value)) ? $params->terms_version->value : '',
                //'Emails_Promocion'     => ($params && isset($params->newsletter->value) && $params->newsletter->value == 1) ? 'SI' : 'NO',
                'Medio_Pago'           => ($params && isset($params->mpago->value)) ? $params->mpago->value : '',
                'CC_Nombre'            => ($params && isset($params->tnombres->value)) ? substr(preg_replace('/\s+/', ' ', $params->tnombres->value), 0, 50) : '',
                'CC_Nro'               => ($params && isset($params->ntarjeta->value)) ? $params->ntarjeta->value : '',
                'CC_CVV'               => ($params && isset($params->tcvv->value)) ? $params->tcvv->value : '',
                'CC_Type'              => ($params && isset($params->tcctype->value)) ? $params->tcctype->value : '',
                'CC_Fecha_Venc'        => ($params && isset($params->ftarjeta->value)) ? substr($params->ftarjeta->value, 0, 2).'20'.substr($params->ftarjeta->value, 3, 2) : '',
                'Email_Enviado'        => ($log->send_mail == 1) ? 'SI' : 'NO',
                'Fecha_Venta'          => $log->created_at->format('d/m/Y'),
                'File'                 => $log->file ?? '',
                'IP'                   => $log->ip_info ?? '',
                // …agregá los campos que necesites
            ];

            // Creamos la hoja con el nombre del evento
            $sheet = $spreadsheet->createSheet($sheetIndex++);
            // los nombres de hoja no pueden superar 31 caracteres
            $sheet->setTitle(substr($evento, 0, 31));

            // ✅ Escribir encabezados (fila 1)
            $rowNumber = 1;
            $colIndex  = 1;
            foreach ($row as $titulo => $valor) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue($colLetter.$rowNumber, $titulo);
                $colIndex++;
            }

            // ✅ Escribir valores (fila 2)
            $rowNumber = 2;
            $colIndex  = 1;
            foreach ($row as $titulo => $valor) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex);

                if (in_array($titulo, ['Telefono', 'Imei', 'Documento', 'Cuit'])) {
                    $sheet->setCellValueExplicit(
                        $colLetter.$rowNumber,
                        (string) $valor,
                        DataType::TYPE_STRING
                    );
                    // forzar formato de texto en toda la columna
                    $sheet->getStyle($colLetter)
                          ->getNumberFormat()
                          ->setFormatCode(NumberFormat::FORMAT_TEXT);
                } else {
                    $sheet->setCellValue($colLetter.$rowNumber, $valor);
                }

                $colIndex++;
            }
        }

        if ($spreadsheet->getSheetCount() === 0) {

            $sheet = $spreadsheet->createSheet(0);
            $sheet->setTitle('Sin Datos');

            $headers = $this->getHeaders();

            $colIndex = 1;
            foreach ($headers as $header) {
                $colLetter = Coordinate::stringFromColumnIndex($colIndex);
                $sheet->setCellValue($colLetter.'1', $header);
                $colIndex++;
            }
        }

        // Guardamos en storage/app/temp
        $fileName = $id.'-log_'.$idLog.'.xlsx';
        $path = storage_path('app/temp/'.$fileName);
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        $spreadsheet->setActiveSheetIndex(0);
        
        return $path; // listo para agregar al ZIP
    }
}