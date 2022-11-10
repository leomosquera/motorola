<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models;
use Validator;
use Storage;
use Config;
use Datatables;
use Helper;
use File;
use ZipArchive;
use PDF;
use App;

class InspectionCarController extends Controller
{
    //Filters
    private function filter_date_take(){
        return 'DATE_FORMAT(inspection_cars.date, "%d/%m/%Y")';
    }

    private function filter_usuarios(){
        return 'TRIM(CONCAT(u.name," ",u.lastname))';
    }

    private function filter_damages()
    {
        return '(
            SELECT
            IF(COUNT(DISTINCT(icd.car_damage_id)) > 0, "SI", "NO")
            FROM inspection_car_damage icd
            WHERE icd.inspection_car_id = inspection_cars.id
        )';
    }

    private function filter_images()
    {
        return '(
            SELECT
            COUNT(DISTINCT(ici.id))
            FROM inspection_car_images ici
            WHERE ici.inspection_car_id = inspection_cars.id
        )';
    }

    //public functions
    public function index()
    {
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Lista de Automóviles']
        ];
        return view('pages/admin/inspection-car/index', [
            'page_title' => 'Inspecciones',
            'page_breadcrumbs' => $page_breadcrumbs
        ]);
    }

    public function indexDt(Request $request)
    {
        if ($request->ajax()) {
            $inspection_cars = Models\InspectionCar::query()
                ->join('car_types as ct', function($join) {
                    $join->on('ct.id', '=', 'inspection_cars.car_type_id');
                })
                ->join('usuarios as u', function($join) {
                    $join->on('u.id', '=', 'inspection_cars.usuario_id');
                })
                ->where('inspection_cars.deleted', 0)
                ->selectRaw('
                inspection_cars.*,
                ct.name as type_name,
                '.$this->filter_date_take().' as date_take,
                '.$this->filter_usuarios().' as usuario,
                '.$this->filter_damages().' as damages,
                '.$this->filter_images().' as images
                ');
            return DataTables::of($inspection_cars)
                ->filterColumn('type_name', function ($query, $keyword) {
                    $query->whereRaw("ct.name like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('date_take', function($query, $keyword) {
                    $query->whereRaw($this->filter_date_take()." like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('usuario', function($query, $keyword) {
                    $query->whereRaw($this->filter_usuarios()." like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('damages', function($query, $keyword) {
                    $query->whereRaw($this->filter_damages()." like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('images', function($query, $keyword) {
                    $query->whereRaw($this->filter_images()." like ?", ["%{$keyword}%"]);
                })
                //->addColumn('action', '<a href="{{ route(\'inspection-car-edit\', $id) }}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Editar"><i class="la la-edit"></i></a> <a href="{{ route(\'tools-zip-inspection-car\', $id) }}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Descargar ZIP"><i class="la la-file-zip-o"></i></a> <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-route="{{ route(\'inspection-car-destroy\') }}" data-action="delete" data-id="{{$id}}" data-question="Desea eliminar la inspección patente &quot;{{ $patent.\' de \'.$name }}&quot; ?" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="la la-trash"></i></a>')
                ->addColumn('action', '<a href="{{ route(\'inspection-car-edit\', $id) }}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Editar"><i class="la la-edit"></i></a> <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-action="speedway" data-id="{{$id}}" data-route="{{ route(\'inspection-car-speedway\') }}" data-toggle="tooltip" data-placement="top" title="Enviar al Speedway"><i class="las la-sync"></i> <a href="{{ route(\'inspection-car-pdf-inspection\', $id) }}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Descargar PDF"><i class="las la-download"></i></a> <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-route="{{ route(\'inspection-car-destroy\') }}" data-action="delete" data-id="{{$id}}" data-question="Desea eliminar la inspección patente &quot;{{ $patent.\' de \'.$name }}&quot; ?" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="la la-trash text-danger"></i></a>')
                ->rawColumns(['action'])
                ->make(true);
        } else {
            abort(404);
        }
    }

    public function create()
    {
        $car_types = Models\CarType::all();
        $usuarios  = Models\Usuario::all();

        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => 'admin/inspection/car', 'title' => 'Lista de Automóviles'], ['page' => false, 'title' => 'Crear inspección']
        ];
        return view('pages/admin/policy/create', [
            'page_title' => 'Crear inspección',
            'page_breadcrumbs' => $page_breadcrumbs,
            'car_types' => $car_types,
            'usuarios' => $usuarios
        ]);
    }

    public function store(Request $request){
        try{
            $policy = Models\InspectionCar::create($request->all()) ?? false;
            if($policy){
                return redirect()->route('policy')->with('response',['success','Correctamente!','Se agregó una inspección.']);
            }else{
                return redirect()->route('policy')->with('response',['error','Error!','No se agregó la inspección.']);
            }
        }
        catch(\Exception $e){
            return redirect()->route('policy')->with('response',['error','Error',$e->getMessage()]);
        }
    }

    public function edit( $id = 0 ){
        $data       = Models\InspectionCar::where('id', $id)->first() ?? false;
        $data->date = Helper::formatDate(substr($data->date,0,10));
        $car_types = Models\CarType::all();
        $usuarios  = Models\Usuario::all();
        /** images */
        $images = [
            'type'   => 'multiple',
            'images' => []
        ];
        if($images['type']=='unique'){
            array_push($images['images'], $data->image);
        }else{
            if($data->images()){
                $images['images'] = $data->images()->get();
            }
        }
        /** gnc */
        $gnc = [
            'type'   => 'multiple',
            'images' => []
        ];
        if($gnc['type']=='unique'){
            array_push($gnc['images'], $data->image);
        }else{
            if($data->gnc()){
                $gnc['images'] = $data->gnc()->get();
            }
        }
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => 'admin/inspection/car', 'title' => 'Lista de Automóviles'], ['page' => false, 'title' => 'Editar inspección']
        ];
        return view('pages/admin/inspection-car/edit', [
            'page_title' => 'Editar Inspección',
            'page_breadcrumbs' => $page_breadcrumbs,
            'data' => $data,
            'car_types' => $car_types,
            'usuarios' => $usuarios,
            'images' => $images,
            'gnc' => $gnc
        ]);
    }

    public function update(Request $request, $id){
        try{
            $inspection_cars = Models\InspectionCar::where('id', $id)->first() ?? false;
            if($inspection_cars){
                //$policy->update($request->all());
                $inspection_cars->update(
                    [
                        'patent' => strtoupper($request->patent),
                        'status' => strtoupper($request->status)
                    ]
                );
                return redirect()->route('inspection-car')->with('response',['success','Correctamente!','Se modificó la inspección']);
            }else{
                return redirect()->route('inspection-car')->with('response',['error','Error','No se modificó la inspección o no posee permiso para editarla.']);
            }
        }
        catch(\Exception $e){
            return redirect()->route('inspection-car')->with('response',['error','Error',$e->getMessage()]);
        }
    }

    public function destroy(Request $request){
        if ($request->ajax()) {
            try {
                $data = Models\InspectionCar::where('id', $request->id)->first() ?? false;
                if ($data) {
                    /*
                    foreach ($data->images()->get() as $image){
                        Helper::imageDelete(Config::get('models.inspection-car.image.dir'), $image->image);
                    }
                    foreach ($data->gnc()->get() as $gnc){
                        Helper::imageDelete(Config::get('models.inspection-car.gnc.dir'), $gnc->image);
                    }
                    */
                    $data->deleted = 1;
                    $data->save();
                    return \Response::json(array('response' => ['success', 'Correctamente!', 'Se borró la inspección!']));
                } else {
                    return \Response::json(array('response' => ['error', 'Error!', 'La inspección no puede eliminarse.']));
                }
            } catch (\Exception $e) {
                return \Response::json(array('response' => ['error', 'Error', $e->getMessage()]));
            }
        } else {
            abort(404);
        }
    }

    public function speedway(Request $request){
        if ($request->ajax()) {
            try {
                $inspcar = Models\InspectionCar::where('id', $request->id)->first() ?? false;
                if ($inspcar) {

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
                        return \Response::json(array('response' => ['success', 'Correctamente!', 'Se envió la inspección al Speedway!']));
                    }else{
                        return \Response::json(array('response' => ['error', 'Error!', 'La inspección no puede ser enviada porque faltan fotos o no cumple con la información necesaria para enviar al Speedway!']));
                    }
                } else {
                    return \Response::json(array('response' => ['error', 'Error!', 'La inspección no puedo enviarse.']));
                }
            } catch (\Exception $e) {
                return \Response::json(array('response' => ['error', 'Error', $e->getMessage()]));
            }
        } else {
            abort(404);
        }
    }

    public function pdfInspection( $id = 0 ){

        $data = Models\InspectionCar::where('id', $id)->first() ?? false;

        //view()->share('users.pdf',$data);

        //$pdf = PDF::loadView('pages/admin/inspection-car/pdf/inspection', ['data' => $data]);

        //return $pdf->download('users.pdf');



        $order['data'] = $data;

        //dd($order['pdf_config']->name);

        $pdf = PDF::setOptions([
          'isRemoteEnabled' => true,
          'isHtml5ParserEnabled' => true,
          'defaultPaperSize' => 'a4',
          'dpi' => 110,
          'defaultFont' => 'sans-serif',
          'chroot'  => base_path()
          ])
          ->loadView('/pages/admin/inspection-car/pdf/inspection', compact('order'));
        return $pdf->stream();

    }

    public function imageEdit( $id = 0 ){
        $data = Models\InspectionCarImage::where('id', $id)->first() ?? false;
        if($data){
            $page_breadcrumbs = [
                ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Editar imagen']
            ];
            return view('pages/admin/inspection-car/image/replace', [
                'page_title' => 'Editar Imagen',
                'page_breadcrumbs' => $page_breadcrumbs,
                'data' => $data
            ]);
        }else{
            return redirect()->back()->with('response',['error','Error!','No se encontro la imagen seleccionada.']);
        }
    }

    public function imageReplace(Request $request){
        try {
            $data = Models\InspectionCarImage::where('id', $request->id)->first() ?? false;
            if($data){
                $return = route('inspection-car-edit', $data->inspection_car_id);
                $dir = Config::get('models.inspection-car.image.dir');
                $delete = Helper::imageDelete($dir, $data->image);
                if($delete){
                    $data->update(['image' => NULL]);
                    $path = $dir;
                    $string_pieces = explode( ";base64,", $request->image);
                    // Get type of image ex. png, jpg, etc.
                    // $image_type[1] will return type
                    $image_type_pieces = explode( "image/", $string_pieces[0] );
                    $image_type = $image_type_pieces[1];
                    // Create full path with image name and extension
                    $image_new_name = md5(uniqid()).'.'.$image_type;
                    $store_at = $path.$image_new_name;
                    // If image name available then use that
                    if ( !empty($image_name) ) :
                        $store_at = $path.$image_name.'.'.$image_type;
                    endif;
                    $decoded_string = base64_decode(substr($request->image, strpos($request->image, ",")+1));
                    $new_image = Storage::put($store_at, $decoded_string);

                    if($new_image){
                        $data->update(['image' => $image_new_name]);
                        return \Response::json(array('response' => ['success', 'Correctamente!', 'La imagen se reemplazó correctamente.', $return]));
                    }else{
                        return \Response::json(array('response' => ['error', 'Error', 'No se pudo reemplazar la imagen']));
                    }

                }else{
                    return \Response::json(array('response' => ['error', 'Error', 'No se pudo reemplazar la imagen']));
                }
            }else{
                return \Response::json(array('response' => ['error', 'Error', 'No se encontró la imagen a reemplazar.']));
            }
        } catch (\Exception $e) {
            return \Response::json(array('response' => ['error', 'Error', $e->getMessage()]));
        }
    }

    public function gncEdit( $id = 0 ){
        $data = Models\InspectionCarGnc::where('id', $id)->first() ?? false;
        if($data){
            $page_breadcrumbs = [
                ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Editar GNC']
            ];
            return view('pages/admin/inspection-car/gnc/replace', [
                'page_title' => 'Editar GNC',
                'page_breadcrumbs' => $page_breadcrumbs,
                'data' => $data
            ]);
        }else{
            return redirect()->back()->with('response',['error','Error!','No se encontro la imagen seleccionada.']);
        }
    }

    public function gncReplace(Request $request){
        try {
            $data = Models\InspectionCarGnc::where('id', $request->id)->first() ?? false;
            if($data){
                $return = route('inspection-car-edit', $data->inspection_car_id);
                $dir = Config::get('models.inspection-car.gnc.dir');
                $delete = Helper::imageDelete($dir, $data->image);
                if($delete){
                    $data->update(['image' => NULL]);
                    $path = $dir;
                    $string_pieces = explode( ";base64,", $request->image);
                    // Get type of image ex. png, jpg, etc.
                    // $image_type[1] will return type
                    $image_type_pieces = explode( "image/", $string_pieces[0] );
                    $image_type = $image_type_pieces[1];
                    // Create full path with image name and extension
                    $image_new_name = md5(uniqid()).'.'.$image_type;
                    $store_at = $path.$image_new_name;
                    // If image name available then use that
                    if ( !empty($image_name) ) :
                        $store_at = $path.$image_name.'.'.$image_type;
                    endif;
                    $decoded_string = base64_decode(substr($request->image, strpos($request->image, ",")+1));
                    $new_image = Storage::put($store_at, $decoded_string);

                    if($new_image){
                        $data->update(['image' => $image_new_name]);
                        return \Response::json(array('response' => ['success', 'Correctamente!', 'La imagen se reemplazó correctamente.', $return]));
                    }else{
                        return \Response::json(array('response' => ['error', 'Error', 'No se pudo reemplazar la imagen']));
                    }

                }else{
                    return \Response::json(array('response' => ['error', 'Error', 'No se pudo reemplazar la imagen']));
                }
            }else{
                return \Response::json(array('response' => ['error', 'Error', 'No se encontró la imagen a reemplazar.']));
            }
        } catch (\Exception $e) {
            return \Response::json(array('response' => ['error', 'Error', $e->getMessage()]));
        }
    }

    public function charts()
    {
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Estadísticas Insp. de Automóviles']
        ];
        return view('pages/admin/inspection-car/charts', [
            'page_title' => 'Estadísticas Insp. de Automóviles',
            'page_breadcrumbs' => $page_breadcrumbs
        ]);
    }

    public function chartLineMonth(Request $request)
    {
        if ($request->ajax()) {
            $carbon_date = Carbon::now()->subMonths($request->info+1);
            $data = array();
            $categories = array();

            for($m=1;$m<=$request->info;$m++){
                $carbon_date->addMonth(1);
                array_push($categories,substr(Config::get('es.month')[$carbon_date->format('n')],0,3));
                array_push(
                    $data,
                    Models\InspectionCar::whereMonth('date', '=', $carbon_date->format('m'))->whereYear('date', '=', $carbon_date->format('Y'))->count() ?? 0
                );
            }
            //dd($data);
            return \Response::json(
                array(
                    'response' => 'success',
                    'data' => [
                        'data'       => $data,
                        'categories' => $categories
                    ]
                )
            );
        }else{
            abort(404);
        }
    }

    public function chartLineMonthCompare(Request $request)
    {
        if ($request->ajax()) {
            $carbon_date = Carbon::now()->subMonth(1);
            $start_month = ( $carbon_date->format('n')-1 > 0 ? $carbon_date->format('n')-1 : 12 );
            $start_year  = ( $carbon_date->format('n')-1 > 0 ? $carbon_date->format('Y') : $carbon_date->format('Y')-1 );
            $end_day     = 31;
            $end_month   = $carbon_date->format('m');
            $end_year    = $carbon_date->format('Y');

            $data_days   = array();
            $data_month1 = array();
            $data_month2 = array();
            for($day=1;$day<=31;$day++){
                if( $day >= 1 && $day <= 5 && $day <= $end_day ){
                    array_push(
                        $data_month1,
                        Models\InspectionCar::whereDay('date', '>=', '01')
                        ->whereDay('date', '<=', '05')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\InspectionCar::whereDay('date', '>=', '01')
                        ->whereDay('date', '<=', '05')
                        ->whereMonth('date', '=', ($end_month<10?'0'.$end_month:$end_month))
                        ->whereYear('date', '=', $end_year)
                        ->count() ?? 0
                    );
                    array_push($data_days, '1-5');
                    $day = 5;
                }elseif( $day >= 6  && $day <= 10 && $day <= $end_day ){
                    array_push(
                        $data_month1,
                        Models\InspectionCar::whereDay('date', '>=', '06')
                        ->whereDay('date', '<=', '10')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\InspectionCar::whereDay('date', '>=', '06')
                        ->whereDay('date', '<=', '10')
                        ->whereMonth('date', '=', ($end_month<10?'0'.$end_month:$end_month))
                        ->whereYear('date', '=', $end_year)
                        ->count() ?? 0
                    );
                    array_push($data_days, '6-10');
                    $day = 10;
                }elseif( $day >= 11 && $day <= 15 && $day <= $end_day ){
                    array_push(
                        $data_month1,
                        Models\InspectionCar::whereDay('date', '>=', '11')
                        ->whereDay('date', '<=', '15')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\InspectionCar::whereDay('date', '>=', '11')
                        ->whereDay('date', '<=', '15')
                        ->whereMonth('date', '=', ($end_month<10?'0'.$end_month:$end_month))
                        ->whereYear('date', '=', $end_year)
                        ->count() ?? 0
                    );
                    array_push($data_days, '11-15');
                    $day = 15;
                }elseif( $day >= 16 && $day <= 20 && $day <= $end_day ){
                    array_push(
                        $data_month1,
                        Models\InspectionCar::whereDay('date', '>=', '16')
                        ->whereDay('date', '<=', '20')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\InspectionCar::whereDay('date', '>=', '16')
                        ->whereDay('date', '<=', '20')
                        ->whereMonth('date', '=', ($end_month<10?'0'.$end_month:$end_month))
                        ->whereYear('date', '=', $end_year)
                        ->count() ?? 0
                    );
                    array_push($data_days, '16-20');
                    $day = 20;
                }elseif( $day >= 21 && $day <= 25 && $day <= $end_day ){
                    array_push(
                        $data_month1,
                        Models\InspectionCar::whereDay('date', '>=', '21')
                        ->whereDay('date', '<=', '25')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\InspectionCar::whereDay('date', '>=', '21')
                        ->whereDay('date', '<=', '25')
                        ->whereMonth('date', '=', ($end_month<10?'0'.$end_month:$end_month))
                        ->whereYear('date', '=', $end_year)
                        ->count() ?? 0
                    );
                    array_push($data_days, '21-25');
                    $day = 25;
                }elseif( $day >= 26 && $day <= $end_day ){
                    array_push(
                        $data_month1,
                        Models\InspectionCar::whereDay('date', '>=', '26')
                        ->whereDay('date', '<=', '31')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\InspectionCar::whereDay('date', '>=', '26')
                        ->whereDay('date', '<=', '31')
                        ->whereMonth('date', '=', ($end_month<10?'0'.$end_month:$end_month))
                        ->whereYear('date', '=', $end_year)
                        ->count() ?? 0
                    );
                    array_push($data_days, '+26');
                    $day = 31;
                }else{
                    break;
                }

            }
            //dd($data);
            return \Response::json(
                array(
                    'response' => 'success',
                    'data' => [
                        'start'  => $end_day.'/'.$start_month.'/'.$start_year,
                        'end'    => $end_day.'/'.$end_month.'/'.$end_year,
                        'month1' => Config::get('es.month')[$start_month],
                        'month2' => Config::get('es.month')[$carbon_date->format('n')],
                        'data1'  => $data_month1,
                        'data2'  => $data_month2,
                        'data3'  => $data_days
                    ]
                )
            );
        }else{
            abort(404);
        }
    }

    public function chartBarMonthCompare(Request $request)
    {
        if ($request->ajax()) {
            $carbon_date = Carbon::now()->subMonths($request->info+1);
            $data1 = array();
            $data2 = array();
            $data3 = array();
            $categories = array();

            for($m=1;$m<=$request->info;$m++){
                $carbon_date->addMonth(1);
                array_push($categories,substr(Config::get('es.month')[$carbon_date->format('n')],0,3));
                array_push(
                    $data1,
                    Models\InspectionCar::whereMonth('date', '=', $carbon_date->format('m'))->whereYear('date', '=', $carbon_date->format('Y'))->count() ?? 0
                );
                array_push(
                    $data2,
                    Models\InspectionBoat::whereMonth('date', '=', $carbon_date->format('m'))->whereYear('date', '=', $carbon_date->format('Y'))->count() ?? 0
                );
                array_push(
                    $data3,
                    Models\SinisterCar::whereMonth('date', '=', $carbon_date->format('m'))->whereYear('date', '=', $carbon_date->format('Y'))->count() ?? 0
                );
            }
            //dd($data);
            return \Response::json(
                array(
                    'response' => 'success',
                    'data' => [
                        'data1'      => $data1,
                        'data2'      => $data2,
                        'data3'      => $data3,
                        'categories' => $categories
                    ]
                )
            );
        }else{
            abort(404);
        }
    }

    public function ftp()
    {
        //$localFile = File::get(Storage::path(Config::get('models.inspection-car.zip.dir').$fileName));
        //Storage::disk('ftp')->put($fileName, $localFile);

        $fileName = 'tvih7p2fhhwoc4888k0s0gc0.zip';
        $isExists = Storage::exists(Config::get('models.inspection-car.zip.dir').'/'.$fileName);
        if($isExists){
            $localFile = File::get(Storage::path(Config::get('models.inspection-car.zip.dir').'/'.$fileName));
            dd(Storage::disk('ftp')->put($fileName, $localFile));
        }else{
            dd('FTP - no subio');
        }
    }

}
