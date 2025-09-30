<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;
use App\Models\CampaignLog;
use App\Models\Assurant\Provincia;
use App\Models\Assurant\EstadoCivil;
use App\Models\Celular;

class TerminosService
{
    /**
     * Arma el array de información de términos y condiciones.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function buildTerminosData($idLog): array
    {
        $data = CampaignLog::where('id_log', $idLog)
            ->where('event', 'datos personales')
            ->latest('id')
            ->first();

        if (!$data) {
            throw new \RuntimeException('Información de datos personales no encontrada');
        }

        $params   = json_decode($data->params);

        $prov_data    = Provincia::where('cod', $params->provincia->value)->first() ?? false;
        $celular_data = Celular::where('code', $params->codarticulo->value)->first() ?? false;
        $estadocivil  = EstadoCivil::where('cod', $params->estadocivil->value)->first() ?? false;

        return [
            'version'               => $params->terms_version->value,
            'fventa'                => substr($params->fventa->value, 0, 2).'/'.substr($params->fventa->value, 3, 2).'/'.substr($params->fventa->value, 6, 4),
            'nombre'                => substr(preg_replace('/\s+/', ' ', $params->apellidos->value.' '.$params->nombres->value), 0, 100),
            'dni'                   => 'DNI '.$params->tndoc->value,
            'cuit'                  => $params->tncuit->value,
            'fnac'                  => substr($params->fnac->value, 0, 2).'/'.substr($params->fnac->value, 3, 2).'/'.substr($params->fnac->value, 6, 4),
            'estadocivil'           => $estadocivil->desc,
            'nacionalidad'          => 'Argentina',
            'domicilio'             => substr(preg_replace('/\s+/', ' ', $params->calle->value.' '.$params->callenro->value.' '.$params->piso->value.' '.$params->dto->value), 0, 100),
            'localidad'             => substr(preg_replace('/\s+/', ' ', $params->localidad->value), 0, 100),
            'provincia'             => substr(preg_replace('/\s+/', ' ', $prov_data->nombre), 0, 50),
            'cp'                    => substr(preg_replace('/\s+/', ' ', $params->cp->value), 0, 25),
            'telefono'              => substr(preg_replace('/\s+/', ' ', $params->tel->value), 0, 15),
            'email'                 => substr(preg_replace('/\s+/', ' ', $params->email->value), 0, 60),
            'ocupacion'             => $params->ocupacion->value,
            'pers'                  => $params->pers->value,
            'sujetoso'              => $params->sujetoso->value,
            'producto_version'      => substr(preg_replace('/\s+/', ' ', $celular_data->version), 0, 100),
            'imei'                  => $params->imei->value,
            'producto_precio'       => '$ '.number_format($celular_data->precio_bruto_equipo, 2, ',', '.'),
            'producto_precio_seguro'=> '$ '.number_format($celular_data->precio_seguro, 2, ',', '.'),
            'elita'                 => $celular_data->elita
        ];
    }

    /**
     * Genera un PDF del view de términos para el id_log dado.
     * Devuelve la ruta física del archivo creado.
     */
    public function generatePdf(string $idLog): string
    {
        // Reutilizamos la misma lógica
        $terminos = $this->buildTerminosData($idLog);

        $viewPath = 'terms.'.$terminos['version'].'.'.strtolower(substr($terminos['elita'], 0, 2));
        if (!View::exists($viewPath)) {
            throw new \RuntimeException("Versión de términos no encontrada");
        }

        $baseUrl = 'https://proteccion-motocare.com.ar';

        // Renderizamos la vista en PDF
        $pdf = Pdf::loadView($viewPath, [
            'logo'     => asset('storage/img/motorola/logo.png'),
            'terminos' => $terminos
        ])->setPaper('A4','portrait'); // podés ajustar tamaño u orientación

        // Guardar en storage/app/temp (por ejemplo)
        $fileName = 'terminos_'.$idLog.'.pdf';
        $path = storage_path('app/temp/'.$fileName);

        // Crear carpeta si no existe
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        $pdf->save($path);

        return $path; // para luego agregarlo al ZIP
    }
}
