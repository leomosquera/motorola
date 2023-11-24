<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use App\Helper\Helper;
use App\Models\InspectionCar;
use App\Models;
use File;
use ZipArchive;
use Config;
use Storage;

class ProcessInspectionCar implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $inspection_car;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(InspectionCar $inspection_car)
    {
        $this->inspection_car = $inspection_car;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            if($this->inspection_car) {
                $inspcar = $this->inspection_car;

                //chequeo cantidad de fotos para enviar al speedway
                $countimg = 0;
                foreach ($inspcar->images()->get() as $image){
                    if (Storage::exists(Config::get('models.inspection-car.image.dir').$image->image)) {
                        $countimg++;
                    }
                }

                if($countimg==7 && $inspcar->deleted==0){
                    //Vars
                    $danios_map  = $inspcar->damages()->get()->pluck('part')->pluck('name')->toArray();
                    $strBueno    = 'Bueno';
                    $strMalo     = 'Malo';
                    $danios      = '';
                    $puntos      = 0;
                    $cobertura   = 'A';
                    //Danios
                    foreach ($inspcar->damages()->get() as $damage) {
                        $puntos = $puntos + $damage->value;
                        $danios = $danios . '' . $damage->part->name . ' ' . $damage->type->name . ' ' . $damage->status . ' (' . $damage->gaus_code . ');';
                    }
                    //Cobertura
                    $coverages = Models\Coverage::where('id', '>', 0)->orderBy('value','asc') ?? false;
                    foreach ($coverages->get() as $coverage) {
                        $cobertura  = $coverage->code;
                        if ($puntos <= $coverage->value) {
                            break;
                        }
                    }

                    $xw = xmlwriter_open_memory();
                    xmlwriter_set_indent($xw, 1);
                    $res = xmlwriter_set_indent_string($xw, '  ');

                    xmlwriter_start_document($xw, '1.0');

                        // A first element
                        xmlwriter_start_element($xw, 'Realizadas');

                            xmlwriter_start_element($xw, 'Inspeccion');

                                xmlwriter_start_element($xw, 'DatosInspeccion');

                                    // DatosInspeccion
                                    $attributes = [
                                        'fechaInsp'   => Carbon::createFromFormat('Y-m-d H:i:s', $inspcar->date)->format('D M d Y H:i:s') . ' GMT-0300 (Argentina Standard Time)',
                                        'cobertura'   => $cobertura,
                                        'cantFotos'   => $inspcar->images()->count(),
                                        'aseguradora' => 'CheckApp'
                                    ];
                                    foreach( $attributes as $attr => $val ){
                                        xmlwriter_start_attribute($xw, $attr);
                                        xmlwriter_text($xw, $val);
                                        xmlwriter_end_attribute($xw);
                                    }

                                    // Conductor
                                    xmlwriter_start_element($xw, 'Conductor');
                                        $attributes = [
                                            'tipoDocumento' => 'DNI',
                                            'telefono'      => $inspcar->phone,
                                            'provincia'     => '',
                                            'nroDocumento'  => '',
                                            'nombres'       => $inspcar->name,
                                            'localidad'     => '',
                                            'apellido'      => '',
                                            'email'         => $inspcar->email
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // Vehiculo
                                    xmlwriter_start_element($xw, 'Vehiculo');
                                        $attributes = [
                                            'verificaNumeroMotor'  => 'COINCIDE',
                                            'verificaNumeroChasis' => 'COINCIDE',
                                            'valuacionDanos' => '',
                                            'valorInfoauto'  => '',
                                            'uso'            => '',
                                            'titular'        => '',
                                            'tipo'           => 'AUTOMOVIL',
                                            'tapizados'      => 'BUENO',
                                            'puestaEnMarcha' => 'SI',
                                            'nroMotor'       => '',
                                            'nroDocumentoCv' => '',
                                            'modelo'         => '',
                                            'marca'          => '',
                                            'kilometraje'    => '',
                                            'dominio'        => $inspcar->patent,
                                            'documentacion'  => 'DOCUMENTACION OK',
                                            'combustible'    => '',
                                            'color'          => '',
                                            'codigoInfoauto' => '',
                                            'cantidadAsientos' => '4',
                                            'anio'             => $inspcar->year
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // Seguridad
                                    xmlwriter_start_element($xw, 'Seguridad');
                                        $attributes = [
                                            'tieneAlarma'  => 'SI',
                                            'cerradurasFuncionan' => 'SI'
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // Cubiertas
                                    xmlwriter_start_element($xw, 'Cubiertas');

                                        xmlwriter_start_element($xw, 'DelanteraIzquierda');
                                            $attributes = [
                                                'modelo'  => 'OTRA',
                                                'marca' => 'OTRA',
                                                'rodado' => '175/70 13',
                                                'profundidadMm' => '6'
                                            ];
                                            foreach( $attributes as $attr => $val ){
                                                xmlwriter_start_attribute($xw, $attr);
                                                xmlwriter_text($xw, $val);
                                                xmlwriter_end_attribute($xw);
                                            }
                                        xmlwriter_end_element($xw);

                                        xmlwriter_start_element($xw, 'DelanteraDerecha');
                                            $attributes = [
                                                'modelo'  => 'OTRA',
                                                'marca' => 'OTRA',
                                                'rodado' => '175/70 13',
                                                'profundidadMm' => '6'
                                            ];
                                            foreach( $attributes as $attr => $val ){
                                                xmlwriter_start_attribute($xw, $attr);
                                                xmlwriter_text($xw, $val);
                                                xmlwriter_end_attribute($xw);
                                            }
                                        xmlwriter_end_element($xw);

                                        xmlwriter_start_element($xw, 'TraseraIzquierda');
                                            $attributes = [
                                                'modelo'  => 'OTRA',
                                                'marca' => 'OTRA',
                                                'rodado' => '175/70 13',
                                                'profundidadMm' => '6'
                                            ];
                                            foreach( $attributes as $attr => $val ){
                                                xmlwriter_start_attribute($xw, $attr);
                                                xmlwriter_text($xw, $val);
                                                xmlwriter_end_attribute($xw);
                                            }
                                        xmlwriter_end_element($xw);

                                        xmlwriter_start_element($xw, 'TraseraDerecha');
                                            $attributes = [
                                                'modelo'  => 'OTRA',
                                                'marca' => 'OTRA',
                                                'rodado' => '175/70 13',
                                                'profundidadMm' => '6'
                                            ];
                                            foreach( $attributes as $attr => $val ){
                                                xmlwriter_start_attribute($xw, $attr);
                                                xmlwriter_text($xw, $val);
                                                xmlwriter_end_attribute($xw);
                                            }
                                        xmlwriter_end_element($xw);

                                        xmlwriter_start_element($xw, 'Auxilio');
                                            $attributes = [
                                                'modelo'  => 'OTRA',
                                                'marca' => 'OTRA',
                                                'rodado' => '175/70 13',
                                                'profundidadMm' => '6'
                                            ];
                                            foreach( $attributes as $attr => $val ){
                                                xmlwriter_start_attribute($xw, $attr);
                                                xmlwriter_text($xw, $val);
                                                xmlwriter_end_attribute($xw);
                                            }
                                        xmlwriter_end_element($xw);

                                    xmlwriter_end_element($xw);

                                    // AccesoriosComplementarios
                                    xmlwriter_start_element($xw, 'AccesoriosComplementarios');
                                        $attributes = [
                                            'cristalesGrabados'  => 'SI',
                                            'cierreCentralizado' => 'SI',
                                            'autopartesGrabadas' => 'SI',
                                            'alarma'             => 'SI',
                                            'aireAcondicionado'  => 'SI'
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // DatosCamion
                                    xmlwriter_start_element($xw, 'DatosCamion');
                                        $attributes = [
                                            'tipoDeCaja'       => 'NO',
                                            'estadoCaja'       => 'NO',
                                            'eqComplementario' => 'NO',
                                            'cajaDeCarga'      => 'NO',
                                            'alcance'          => 'NO'
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // ParteAnterior
                                    xmlwriter_start_element($xw, 'ParteAnterior');
                                        $attributes = [
                                            'rejillaRadiador' => in_array('rejillaRadiador', $danios_map) ? $strMalo : $strBueno,
                                            'paragolpes' => in_array('paragolpes-anterior', $danios_map) ? $strMalo : $strBueno,
                                            'parabrisasPolarizado' => 'NO',
                                            'parabrisas' => in_array('parabrisas', $danios_map) ? $strMalo : $strBueno,
                                            'luzPosicionIzquierdaFunciona' => 'SI',
                                            'luzPosicionIzquierda' => in_array('luzPosicionIzquierda-anterior', $danios_map) ? $strMalo : $strBueno,
                                            'luzPosicionDerecha' => in_array('luzPosicionDerecha-anterior', $danios_map) ? $strMalo : $strBueno,
                                            'luzGuinoIzquierdaFunciona' => 'SI',
                                            'luzBajaIzquierdaFunciona' => 'SI',
                                            'luzBajaDerechaFunciona' => 'SI',
                                            'luzAltaIzquierdaFunciona' => 'SI',
                                            'luzAltaDerechaFunciona' => 'SI',
                                            'lucesPosicionFuncionan' => 'SI',
                                            'lucesGuinoFuncionan' => 'SI',
                                            'guinoIzquierda' => in_array('guinoIzquierda-anterior', $danios_map) ? $strMalo : $strBueno,
                                            'guinoDerecha' => in_array('guinoDerecha-anterior', $danios_map) ? $strMalo : $strBueno,
                                            'faroIzquierdo' => in_array('faroIzquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'faroDerecho' => in_array('faroDerecho', $danios_map) ? $strMalo : $strBueno,
                                            'capot' => in_array('capot', $danios_map) ? $strMalo : $strBueno
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // LateralDerecho
                                    xmlwriter_start_element($xw, 'LateralDerecho');
                                        $attributes = [
                                            'zocalo' => in_array('zocalo-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'puertaTrasera' => in_array('puertaTrasera-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'puertaDelantera' => in_array('puertaDelantera-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'paranteCentral' => in_array('paranteCentral-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'guardabarroTrasero' => in_array('guardabarroTrasero-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'guardabarroDelantero' => in_array('guardabarroDelantero-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'cristalTrasero' => in_array('cristalTrasero-derecho', $danios_map) ? $strMalo : $strBueno,
                                            'cristalDelantero' => in_array('cristalDelantero-derecho', $danios_map) ? $strMalo : $strBueno
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // PartePosterior
                                    xmlwriter_start_element($xw, 'PartePosterior');
                                        $attributes = [
                                            'paragolpes' => in_array('paragolpes-posterior', $danios_map) ?  $strMalo : $strBueno,
                                            'luzPosicionIzquierdaFunciona' => 'SI',
                                            'luzPosicionIzquierda' => in_array('luzPosicionIzquierda-posterior', $danios_map) ?  $strMalo : $strBueno,
                                            'luzPosicionDerecha' => in_array('luzPosicionDerecha-posterior', $danios_map) ?  $strMalo : $strBueno,
                                            'luzGuinoIzquierdaFunciona' => 'SI',
                                            'lucesPosicionFuncionan' => 'SI',
                                            'lucesGuinoFuncionan' => 'SI',
                                            'guinoIzquierda' => in_array('guinoIzquierda-posterior', $danios_map) ?  $strMalo : $strBueno,
                                            'guinoDerecha' => in_array('guinoDerecha-posterior', $danios_map) ?  $strMalo : $strBueno,
                                            'panelDeCola' => in_array('panelDeCola', $danios_map) ?  $strMalo : $strBueno,
                                            'luzMarchaAtrasIzquierdaFunciona' => 'SI',
                                            'luzMarchaAtrasIzquierda' => in_array('luzMarchaAtrasIzquierda', $danios_map) ?  $strMalo : $strBueno,
                                            'luzMarchaAtrasDerecha' => in_array('luzMarchaAtrasDerecha', $danios_map) ?  $strMalo : $strBueno,
                                            'luzFrenoIzquierdaFunciona' => 'SI',
                                            'luzFrenoIzquierda' => in_array('luzFrenoIzquierda', $danios_map) ?  $strMalo : $strBueno,
                                            'luzFrenoDerecha' => in_array('luzFrenoDerecha', $danios_map) ?  $strMalo : $strBueno,
                                            'luneta' => in_array('luneta', $danios_map) ?  $strMalo : $strBueno,
                                            'lucesMarchaAtrasFuncionan' => 'SI',
                                            'lucesFrenoFuncionan' => 'SI',
                                            'cerraduraBaulFunciona' => 'SI',
                                            'baulPorton' => in_array('baulPorton', $danios_map) ?  $strMalo : $strBueno
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // TechoCapota
                                    xmlwriter_start_element($xw, 'TechoCapota');
                                        $attributes = [
                                            'estado' => in_array('techoCapota', $danios_map) ?  $strMalo : $strBueno
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // LateralIzquierdo
                                    xmlwriter_start_element($xw, 'LateralIzquierdo');
                                        $attributes = [
                                            'zocalo' => in_array('zocalo-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'puertaTrasera' => in_array('puertaTrasera-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'paranteCentral' => in_array('paranteCentral-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'puertaDelantera' => in_array('puertaDelantera-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'guardabarroTrasero' => in_array('guardabarroTrasero-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'guardabarroDelantero' => in_array('guardabarroDelantero-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'cristalTrasero' => in_array('cristalTrasero-izquierdo', $danios_map) ? $strMalo : $strBueno,
                                            'cristalDelantero' => in_array('cristalDelantero-izquierdo', $danios_map) ? $strMalo : $strBueno
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                    xmlwriter_end_element($xw);

                                    // Observaciones
                                    xmlwriter_start_element($xw, 'Observaciones');
                                    xmlwriter_text($xw, $danios);
                                    xmlwriter_end_element($xw);

                                    // cartaDeDanios
                                    xmlwriter_start_element($xw, 'cartaDeDanios');
                                    xmlwriter_text($xw, $danios);
                                    xmlwriter_end_element($xw);

                                    //images
                                    $i = 0;
                                    foreach ($inspcar->images()->get() as $image) {
                                        // foto
                                        $i++;
                                        xmlwriter_start_element($xw, 'foto');
                                        $attributes = [
                                            'encoding'   => 'Base64',
                                            'formato'    => 'jpeg',
                                            'fotoNumero' => $i
                                        ];
                                        foreach( $attributes as $attr => $val ){
                                            xmlwriter_start_attribute($xw, $attr);
                                            xmlwriter_text($xw, $val);
                                            xmlwriter_end_attribute($xw);
                                        }
                                        if(file_exists(Storage::path(Config::get('models.inspection-car.image.dir').$image->image))){
                                            xmlwriter_text($xw, Helper::imageEncodeBase64(Config::get('models.inspection-car.image.dir').$image->image,false));
                                        }
                                        xmlwriter_end_element($xw);
                                    }

                                xmlwriter_end_element($xw);

                            xmlwriter_end_element($xw);

                        xmlwriter_end_element($xw);

                    xmlwriter_end_document($xw);

                    //guardo xml
                    $fileXml = $inspcar->_id.'.xml';
                    Storage::put(Config::get('models.inspection-car.xml.dir').$fileXml, xmlwriter_output_memory($xw));

                    if(Storage::exists(Config::get('models.inspection-car.xml.dir').$fileXml)){
                        //genero .zip con el xml dentro
                        $zip  = new ZipArchive;
                        $dirXmlFiles = Config::get('models.inspection-car.xml.dir');
                        $fileZip = $inspcar->_id.'.zip';
                        if ($zip->open(Storage::path(Config::get('models.inspection-car.zip.dir').$fileZip), ZipArchive::CREATE) === TRUE)
                        {
                            $files = [];
                            array_push($files, Storage::path($dirXmlFiles.$fileXml));
                            foreach ($files as $key => $value) {
                                $relativeNameInZipFile = basename($value);
                                $zip->addFile($value, $relativeNameInZipFile);
                            }
                            $zip->close();
                        }
                        //borro xml
                        Storage::delete(Config::get('models.inspection-car.xml.dir').$fileXml);

                        //subo .zip por ftp
                        if(Storage::exists(Config::get('models.inspection-car.zip.dir').'/'.$fileZip)){
                            $localFile = File::get(Storage::path(Config::get('models.inspection-car.zip.dir').'/'.$fileZip));
                            Storage::disk('ftp')->put($fileZip, $localFile);
                            //borro zip
                            Storage::delete(Config::get('models.inspection-car.zip.dir').'/'.$fileZip);
                        }

                    }

                    //subio a sw
                    /*$inspection_cars = Models\InspectionCar::where('id', $id)->first() ?? false;
                    if($inspection_cars){
                        $inspection_cars->update(
                            [
                                'patent' => strtoupper($request->patent),
                                'status' => strtoupper($request->status)
                            ]
                        );
                    }
                    */
                    $inspcar->update(['sw' => 1]);
                }
            }
        }catch(\Exception $e){
            return false;
        }
    }
}
