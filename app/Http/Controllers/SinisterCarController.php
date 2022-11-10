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
use App;

class SinisterCarController extends Controller
{
    //Filters
    private function filter_date_take(){
        return 'DATE_FORMAT(sinister_cars.date, "%d/%m/%Y")';
    }

    private function filter_usuarios(){
        return 'TRIM(CONCAT(u.name," ",u.lastname))';
    }

    private function filter_parts()
    {
        return '(
            SELECT
            COUNT(DISTINCT(scp.car_part_id))
            FROM sinister_car_part scp
            WHERE scp.sinister_car_id = sinister_cars.id
        )';
    }

    private function filter_images()
    {
        return '(
            SELECT
            COUNT(DISTINCT(sci.id))
            FROM sinister_car_images sci
            WHERE sci.sinister_car_id = sinister_cars.id
        )';
    }

    //public functions
    public function index()
    {
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Lista de Automóviles']
        ];
        return view('pages/admin/sinister-car/index', [
            'page_title' => 'Siniestros',
            'page_breadcrumbs' => $page_breadcrumbs
        ]);
    }

    public function indexDt(Request $request)
    {
        if ($request->ajax()) {
            $sinister_cars = Models\SinisterCar::query()
                ->join('car_types as ct', function($join) {
                    $join->on('ct.id', '=', 'sinister_cars.car_type_id');
                })
                ->join('usuarios as u', function($join) {
                    $join->on('u.id', '=', 'sinister_cars.usuario_id');
                })
                ->where('sinister_cars.deleted', 0)
                ->selectRaw('
                sinister_cars.*,
                ct.name as type_name,
                '.$this->filter_date_take().' as date_take,
                '.$this->filter_usuarios().' as usuario,
                '.$this->filter_parts().' as parts,
                '.$this->filter_images().' as images
                ');
            return DataTables::of($sinister_cars)
                ->filterColumn('type_name', function ($query, $keyword) {
                    $query->whereRaw("ct.name like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('date_take', function($query, $keyword) {
                    $query->whereRaw($this->filter_date_take()." like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('usuario', function($query, $keyword) {
                    $query->whereRaw($this->filter_usuarios()." like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('parts', function($query, $keyword) {
                    $query->whereRaw($this->filter_parts()." like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('images', function($query, $keyword) {
                    $query->whereRaw($this->filter_images()." like ?", ["%{$keyword}%"]);
                })
                ->addColumn('action', '<a href="{{ route(\'sinister-car-edit\', $id) }}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Editar"><i class="la la-edit"></i></a> <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-route="{{ route(\'sinister-car-destroy\') }}" data-action="delete" data-id="{{$id}}" data-question="Desea eliminar el siniestro con patente &quot;{{ $patent.\' de \'.$name }}&quot; ?" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="la la-trash"></i></a>')
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
            ['page' => '/', 'title' => 'Home'], ['page' => 'admin/sinister/car', 'title' => 'Lista de Automóviles'], ['page' => false, 'title' => 'Crear siniestro']
        ];
        return view('pages/admin/policy/create', [
            'page_title' => 'Crear siniestro',
            'page_breadcrumbs' => $page_breadcrumbs,
            'car_types' => $car_types,
            'usuarios' => $usuarios
        ]);
    }

    public function store(Request $request){
        try{
            $policy = Models\SinisterCar::create($request->all()) ?? false;
            if($policy){
                return redirect()->route('policy')->with('response',['success','Correctamente!','Se agregó un siniestro.']);
            }else{
                return redirect()->route('policy')->with('response',['error','Error!','No se agregó el siniestro.']);
            }
        }
        catch(\Exception $e){
            return redirect()->route('policy')->with('response',['error','Error',$e->getMessage()]);
        }
    }

    public function edit( $id = 0 ){
        $data       = Models\SinisterCar::where('id', $id)->first() ?? false;
        $data->date = Helper::formatDate(substr($data->date,0,10));
        $car_types  = Models\CarType::all();
        $usuarios   = Models\Usuario::all();
        $parts      = Models\CarPart::all();
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
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => 'admin/sinister/car', 'title' => 'Lista de Automóviles'], ['page' => false, 'title' => 'Editar siniestro']
        ];
        return view('pages/admin/sinister-car/edit', [
            'page_title' => 'Editar Siniestro',
            'page_breadcrumbs' => $page_breadcrumbs,
            'data' => $data,
            'car_types' => $car_types,
            'usuarios' => $usuarios,
            'images' => $images,
            'parts' => $parts
        ]);
    }

    public function update(Request $request, $id){
        try{
            $sinister_cars = Models\SinisterCar::where('id', $id)->first() ?? false;
            if($sinister_cars){
                //$policy->update($request->all());
                $sinister_cars->update(
                    [
                        'patent' => strtoupper($request->patent),
                        'status' => strtoupper($request->status)
                    ]
                );
                return redirect()->route('sinister-car')->with('response',['success','Correctamente!','Se modificó el siniestro']);
            }else{
                return redirect()->route('sinister-car')->with('response',['error','Error','No se modificó el siniestro o no posee permiso para editarla.']);
            }
        }
        catch(\Exception $e){
            return redirect()->route('sinister-car')->with('response',['error','Error',$e->getMessage()]);
        }
    }

    public function destroy(Request $request){
        if ($request->ajax()) {
            try {
                $data = Models\SinisterCar::where('id', $request->id)->first() ?? false;
                if ($data) {
                    $data->deleted = 1;
                    $data->save();
                    return \Response::json(array('response' => ['success', 'Correctamente!', 'Se borró el siniestro!']));
                } else {
                    return \Response::json(array('response' => ['error', 'Error!', 'El siniestro no puede eliminarse.']));
                }
            } catch (\Exception $e) {
                return \Response::json(array('response' => ['error', 'Error', $e->getMessage()]));
            }
        } else {
            abort(404);
        }
    }

    public function imageEdit( $id = 0 ){
        $data = Models\SinisterCarImage::where('id', $id)->first() ?? false;
        if($data){
            $page_breadcrumbs = [
                ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Editar imagen']
            ];
            return view('pages/admin/sinister-car/image/replace', [
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
            $data = Models\SinisterCarImage::where('id', $request->id)->first() ?? false;
            if($data){
                $return = route('sinister-car-edit', $data->sinister_car_id);
                $dir = Config::get('models.sinister-car.image.dir');
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
            ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Estadísticas Siniestros de Automóviles']
        ];
        return view('pages/admin/sinister-car/charts', [
            'page_title' => 'Estadísticas Siniestros de Automóviles',
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
                    Models\SinisterCar::whereMonth('date', '=', $carbon_date->format('m'))->whereYear('date', '=', $carbon_date->format('Y'))->count() ?? 0
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
                        Models\SinisterCar::whereDay('date', '>=', '01')
                        ->whereDay('date', '<=', '05')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\SinisterCar::whereDay('date', '>=', '01')
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
                        Models\SinisterCar::whereDay('date', '>=', '06')
                        ->whereDay('date', '<=', '10')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\SinisterCar::whereDay('date', '>=', '06')
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
                        Models\SinisterCar::whereDay('date', '>=', '11')
                        ->whereDay('date', '<=', '15')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\SinisterCar::whereDay('date', '>=', '11')
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
                        Models\SinisterCar::whereDay('date', '>=', '16')
                        ->whereDay('date', '<=', '20')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\SinisterCar::whereDay('date', '>=', '16')
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
                        Models\SinisterCar::whereDay('date', '>=', '21')
                        ->whereDay('date', '<=', '25')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\SinisterCar::whereDay('date', '>=', '21')
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
                        Models\SinisterCar::whereDay('date', '>=', '26')
                        ->whereDay('date', '<=', '31')
                        ->whereMonth('date', '=', ($start_month<10?'0'.$start_month:$start_month))
                        ->whereYear('date', '=', $start_year)
                        ->count() ?? 0
                    );
                    array_push(
                        $data_month2,
                        Models\SinisterCar::whereDay('date', '>=', '26')
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

    public function filesMove()
    {
        $moved = 0;
        $data = Models\SinisterCar::all() ?? false;
        foreach ($data as $car) {
            //images
            foreach ($car->images()->get() as $img) {
                if (Storage::exists(Config::get('models.inspection-car.image.dir').$img->image)) {
                    Storage::move(Config::get('models.inspection-car.image.dir').$img->image, Config::get('models.sinister-car.image.dir').$img->image);
                    $moved++;
                }
            }
        }
        dd($moved);
    }

}
