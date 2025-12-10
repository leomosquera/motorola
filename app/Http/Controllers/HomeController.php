<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use App\Helper\Helper;
use App\Models;
use Storage;
use ZipArchive;
use App\Services\ReporteService; // <-- tu service para crear Excel y PDF
use App\Services\TerminosService;

use Barryvdh\DomPDF\Facade\Pdf;
use MailerSend\MailerSend;
use MailerSend\Helpers\Builder\Recipient;
use MailerSend\Helpers\Builder\Attachment as MsAttachment;
use MailerSend\Helpers\Builder\EmailParams;
use App\Mail\CertificadoHTML;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private static function sendmail(){
        return config('enviroment.sendmail');
    }

    public function storesQr(){
        //stores
        $stores = Models\Store::where('status',1)
        ->orderBy('dealer_id','ASC')
        ->orderBy('code','ASC');

        $info_store = [];
        foreach ($stores->get() as $store){
            //genero la url de QR
            //$url = 'https://proteccionmobile.com.ar/?'.base64_encode($store->uniqueid); <-- esto genera QR con clave de acceso para cada store
            $url = 'https://proteccion-motocare.com.ar';
            
            // QR code with text
            $image = QrCode::format('svg')->size(300)->generate($url);
            $file_name = 'QR-' . $store->code . '.svg';
            $file_output = '/public/img/qr-code/' . $file_name;
            Storage::disk('local')->put($file_output, $image);
            //guardo en base
            $store->image = $file_name;
            $store->save();
            //gurado en array
            array_push($info_store,[
                'name'  => $store->name,
                'code'  => $store->code,
                'url'   => $url,
                'image' => $store->image
            ]);
        }
	    return view('/pages/stores-qr', ['info_store'=>$info_store]);
    }

    public function stores(){
        $info = [];
        $dealers = Models\Dealer::where('status',1)->orderBy('name','ASC');
        foreach ($dealers->get() as $dealer){
            $info_store = [];
            $stores = Models\Store::where('status',1)->where('dealer_id',$dealer->id)->orderBy('name','ASC');
            foreach ($stores->get() as $store){
                array_push($info_store,[
                    'name' => $store->name,
                    'code' => $store->code,
                    'url'  => 'https://proteccionmobile.com.ar/?'.base64_encode($store->uniqueid)
                ]);
            }
            array_push($info,[
                'name' => $dealer->name,
                'stores' => $info_store
            ]);
        }
        return view('/pages/stores', ['info'=>$info]);
    }

    public function storesMigration(){
        $json = Storage::get('base/migration/motocare_codigo_tiendas.json');
        $json = json_decode($json, true);

        //Actualizacion Familias y Productos
        foreach ($json as $grupo){
            foreach ($grupo as $valor){
                if (array_key_exists('Código Franquicia', $valor)) {
                    $dealer = Models\Dealer::where('name', $valor['GRUPO'])->first() ?? false;
                    $store  = Models\Store::where('code', $valor['Código Franquicia'])->first() ?? false;
                    if($dealer && !$store){
                        $data = new Models\Store();
                        $data->status = 1;
                        $data->dealer_id = $dealer->id;
                        $data->name = $valor['DESCRIPCIÓN'];
                        $data->uniqueid = Str::uuid()->toString();
                        $data->code = $valor['Código Franquicia'];
                        $data->contact = null;
                        $data->address = $valor['Nombre del PDV'] ?? null;
                        $data->location = $valor['Ubicación dentro del shopping'] ?? null;
                        $data->email = null;
                        $data->phone = null;
                        $data->save();
                    }
                }
            }
        }

    }

    //SISTEMA DE ENVIO: ACTIVO
    public function storesHistorySalesByDealer(?bool $force = null, ?bool $includeToday = null)
    {
        // si no lo pasaron, lo leo de la config
        // Se incluye el día actual o no, generalmente hay que enviar todos los logs anteriores al dia de hoy.
        if (is_null($includeToday)) {
            $includeToday = (bool) config('global.log.include_today', false);
        }

        // si no lo pasaron, lo leo de la config
        // forzamos a que se regeneren todos los archivos nuevamente .txt y .zip
        if (!$force) {
            $force = (bool) config('global.log.force', false);
        }
        
        $CC_INFO = [
            'AE' => ['code' => '19'],
            'VI' => ['code' => '13'],
            'MC' => ['code' => '14'],
            'TN' => ['code' => '15'],
            'CA' => ['code' => '16'],
        ];

        $dealer_code = 'MO13';
        $baseDir     = Config::get('global.storage.files'); // ej: 'exports/'
        $subdays     = max(1, (int) config('global.log.subdays', 1));

        for ($d = 0; $d < $subdays; $d++) {
            $day = Carbon::today()->subDays($d);

            // ⛔ Si es hoy y no está permitido procesar hoy
            if ($day->isToday() && !$includeToday) {
                continue;
            }

            $from     = $day->copy()->startOfDay();
            $to       = $day->copy()->endOfDay();
            $fileName = 'AMA_'.$dealer_code.'_ENROLLMENT_MOTO_NV_'.$day->format('Ymd').'.txt';
            $fullPath = $baseDir.$fileName;
            $zipName  = pathinfo($fileName, PATHINFO_FILENAME).'.zip';
            $zipPath  = storage_path('app/'.$baseDir.$zipName);

            $log_count = 0;
            $logsProcesados = [];

            // 🗑️ Si es hoy o se forzó regeneración, borrar TXT + ZIP previos
            if ($day->isToday() || $force) {
                if (Storage::exists($fullPath)) {
                    Storage::delete($fullPath);
                }
                if (file_exists($zipPath)) {
                    unlink($zipPath);
                }
            }

            // ✅ Una única query global por día
            if ($day->isToday() || $force) {
                // Para HOY o si forzamos → procesar todo el día
                $data = Models\CampaignLog::where('payment_code', 'CC')
                    ->where('event', 'medio de pago')
                    ->whereBetween('created_at', [$from, $to])
                    ->orderBy('id', 'asc')
                    ->with('store');
            } else {
                // Para días pasados normales → solo no procesados
                $data = Models\CampaignLog::where('payment_code', 'CC')
                    ->where('event', 'medio de pago')
                    ->whereNull('file')
                    ->whereBetween('created_at', [$from, $to])
                    ->orderBy('id', 'asc')
                    ->with('store');
            }

            $logs = $data->get();

            if ($logs->count() === 0) {
                continue;
            }

            $log_count += $logs->count();

            foreach ($logs as $log) {
                $params   = json_decode($log->params);
                $services = json_decode($log->services);

                foreach ($services->products->data as $product) {
                    if ($params->codarticulo->value != $product->code) {
                        continue;
                    }

                    $prov_data    = Models\Assurant\Provincia::where('cod', $params->provincia->value)->first();
                    $celular_data = Models\Celular::where('code', $params->codarticulo->value)->first();

                    $txt  = 'FC¦';
                    $txt .= '¦';
                    $txt .= '¦';
                    $txt .= $product->precio_bruto_equipo.'¦';
                    $txt .= '0¦';
                    $txt .= '12¦';
                    $txt .= $product->precio_seguro.'¦';
                    $txt .= str_repeat('¦', 2);
                    $txt .= $log->store->code.'¦';
                    $txt .= $log->id.'¦';
                    $txt .= str_replace(['/','-'], ['',''], $params->fventa->value).'¦';
                    $txt .= '¦';
                    $txt .= $params->tndoc->value.'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->nombres->value.' '.$params->apellidos->value), 0, 50).'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->email->value), 0, 50).'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->calle->value.' '.$params->callenro->value.' '.$params->piso->value.' '.$params->dto->value), 0, 50).'¦';
                    $txt .= $params->sujetoso->value.'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->localidad->value), 0, 50).'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->cp->value), 0, 25).'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $prov_data->branch_code ?? ''), 0, 50).'¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->tel->value), 0, 15).'¦';
                    $txt .= '¦';
                    $txt .= 'AR¦';
                    $txt .= 'AR¦';
                    $txt .= 'ARS¦';
                    $txt .= $day->format('dmY').'¦';
                    $txt .= ($celular_data->elita ?? '').'¦';
                    $txt .= '6¦';
                    $txt .= 'MOTOROLA¦';
                    $txt .= substr(preg_replace('/\s+/', ' ', $product->version), 0, 30).'¦';
                    $txt .= substr($params->imei->value, 0, 20).'¦';
                    $txt .= '1¦';
                    $txt .= '12¦';
                    $txt .= $product->precio_seguro.'¦';
                    $txt .= 'C¦';
                    $txt .= str_repeat('¦', 2);
                    $txt .= substr(preg_replace('/\s+/', ' ', $params->tnombres->value), 0, 50).'¦';
                    $txt .= $params->tcctype->value.'¦';
                    $txt .= $params->ntarjeta->value.'¦';
                    $txt .= substr($params->ftarjeta->value, 0, 2).'20'.substr($params->ftarjeta->value, 3, 2).'¦';
                    $txt .= str_repeat('¦', 80);
                    $txt .= substr($params->sexo->value, 0, 1).'¦';
                    $txt .= substr($params->fnac->value, 6, 4).substr($params->fnac->value, 3, 2).substr($params->fnac->value, 0, 2).'¦';
                    $txt .= $params->estadocivil->value.'¦';
                    $txt .= 'AR¦';
                    $txt .= 'AR¦';
                    $txt .= $params->tncuit->value.'¦';
                    $txt .= $params->imei->value.'¦';
                    $txt .= $params->ocupacion->value.'¦';

                    Storage::append($fullPath, Helper::utf8toansi($txt));

                    $data_log = Models\CampaignLog::find($log->id);
                    if ($data_log) {
                        $data_log->payment_verified = 1;
                        $data_log->file = $fileName;
                        $data_log->save();
                    }

                    $logsProcesados[] = ['id_log' => $log->id_log, 'id' => $log->id];

                    break; // salir del foreach de products
                }
            }

            if ($log_count > 0) {
                $header = 'HH¦'.$dealer_code.'¦'.$day->format('Ymd').'¦'.$log_count.'¦';
                Storage::prepend($fullPath, Helper::utf8toansi($header));

                $zip = new ZipArchive();
                if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
                    foreach ($logsProcesados as $logData) {
                        $idLog = $logData['id_log'];
                        $id    = $logData['id'];

                        $folderName = $id.'-log_'.$idLog.'/';
                        $zip->addEmptyDir($folderName);

                        $excelPath = app(ReporteService::class)->generateExcel($idLog, $id);
                        $pdfPath   = app(TerminosService::class)->generatePdf($idLog, $id);

                        $zip->addFile($excelPath, $folderName.basename($excelPath));
                        $zip->addFile($pdfPath,   $folderName.basename($pdfPath));
                    }
                    $zip->close();
                }
            }
        }
    }

    //SISTEMA DE ENVIO: NO ACTIVO
    public function storesHistorySalesByStore(){

         //tarjetas c{odigos para generar file
         $CC_INFO = [
            'AE' => [
                'code' => '19'
            ],
            'VI' => [
                'code' => '13'
            ],
            'MC' => [
                'code' => '14'
            ],
            'TN' => [
                'code' => '15'
            ],
            'CA' => [
                'code' => '16'
            ]
        ];

        // Dealers
        $dealers =  Models\Dealer::where('status', 1);
        foreach ($dealers->get() as $dealer){

            //file setting
            $file = [
                'dir'  => Config::get('global.storage.files'),
                'name' => $dealer->code.date('ymd').'.txt'
            ];

            //log count
            $log_count = 0;

            // Stores
            $stores =  Models\Store::where('status', 1)->where('dealer_id', $dealer->id);
            $stores_update = false;

            foreach ($stores->get() as $store){

                //update log status
                //if(Helper::mpPaymentUpdateAllStatusByStore($store->id)){ --> if solo para MP
                    //selector de log para crear file
                    $data =  Models\CampaignLog::
                    where('store_id', $store->id)
                    ->where('payment_code', 'CC')
                    ->where('event', 'medio de pago')
                    ->where('file',null)
                    ->where('created_at', '>=', Carbon::now()->subDays(config('global.log.subdays')))
                    ->orderBy('id', 'DESC')
                    ->with('store');

                    //dd($data->count().' > STORE > '.$store->id);

                    if($data->count() > 0){
                        //mpPaymentApproved
                        $log_count += $data->count();
                        foreach ($data->get() as $log){
                            $params   = json_decode($log->params);
                            $services = json_decode($log->services);
                            //dd($log->id);
                            //busco en los productos el elegido
                            foreach ($services->products->data as $product){
                                //el producto que coincide con el guardado en params es el elegido
                                if($params->codarticulo->value == $product->code){

                                    /*
                                    $txt = 'FC¦'; //1
                                    $txt .= '¦'; //2
                                    $txt .= $product->sku.'¦'; //3
                                    $txt .= $price->price_gross.'¦';//4
                                    $txt .= '0¦'; //5
                                    $txt .= $price->duration.'¦'; //6
                                    $txt .= $price->price_insured.'¦'; //7
                                    $txt .= '¦¦'; //8-9
                                    $txt .= $log->store->code.'¦'; //10
                                    $txt .= substr($services->payment->payment_id, 0, 20).'¦'; //11
                                    $txt .= str_replace(['/','-'], ['',''], $params->fventa->value).'¦'; //12
                                    $txt .= '¦'; //13
                                    $txt .= $params->tndoc->value.'¦'; //14
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->nombres->value.' '.$params->apellidos->value), 0, 50).'¦'; //15
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->email->value), 0, 50).'¦'; //16
                                    /*
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->calle->value.' '.$params->callenro->value), 0, 50).'¦'; //17
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->piso->value.' '.$params->dto->value), 0, 50).'¦'; //18
                                    */
                                    /*
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->calle->value.' '.$params->callenro->value.' '.$params->piso->value.' '.$params->dto->value), 0, 50).'¦'; //17
                                    $txt .= $params->sujetoso->value.'¦'; //18
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->localidad->value), 0, 50).'¦'; //19
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->cp->value), 0, 25).'¦'; //20
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->provincia->value), 0, 50).'¦'; //21
                                    $txt .= $params->pers->value.'¦'; //22
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->tel->value), 0, 15).'¦'; //23
                                    $txt .= 'AR¦'; //24
                                    $txt .= 'AR¦'; //25
                                    $txt .= 'ARS¦'; //26
                                    $txt .= date('dmY', strtotime($log->created_at)).'¦'; //27 definir bien esta fecha
                                    $txt .= substr($price->idnewsanmotocare, 0, 20).'¦'; //28 ojo porque este valor está al limite ??
                                    $txt .= '1¦'; //29
                                    $txt .= 'MOTOROLA¦'; //30
                                    $txt .= substr(preg_replace('/\s+/', ' ', $product->description), 0, 30).'¦'; //31
                                    $txt .= substr($params->imei->value, 0, 20).'¦'; //32
                                    $txt .= '¦¦¦¦¦¦¦¦¦¦¦¦¦¦'; //33-46
                                    $txt .= substr($price->price_gross, 0, 20).'¦'; //47
                                    $txt .= '¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦'; //48-67
                                    $txt .= $params->sexo->value.'¦'; //68
                                    $txt .= '¦'; //69
                                    $txt .= '03¦';//70
                                    $txt .= 'AR¦'; //71
                                    $txt .= '¦'; //72
                                    $txt .= 'F¦'; //73
                                    $txt .= $params->tncuit->value.'¦'; //74
                                    */

                                    $prov_data    =  Models\Assurant\Provincia::where('cod', $params->provincia->value)->first() ?? false;
                                    $celular_data =  Models\Celular::where('code', $params->codarticulo->value)->first() ?? false;

                                    $txt = 'FC¦'; //1
                                    $txt .= '¦'; //2
                                    $txt .= '¦'; //3
                                    $txt .= $product->precio_bruto_equipo.'¦';//4
                                    $txt .= '0¦'; //5
                                    $txt .= '12¦'; //6
                                    $txt .= $product->precio_seguro.'¦'; //7
                                    $txt .= '¦¦'; //8-9
                                    $txt .= 'MO12E¦'; //10
                                    $txt .= $log->id.'¦'; //11
                                    $txt .= str_replace(['/','-'], ['',''], $params->fventa->value).'¦'; //12
                                    $txt .= '¦'; //13
                                    $txt .= $params->tndoc->value.'¦'; //14
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->nombres->value.' '.$params->apellidos->value), 0, 50).'¦'; //15
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->email->value), 0, 50).'¦'; //16
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->calle->value.' '.$params->callenro->value.' '.$params->piso->value.' '.$params->dto->value), 0, 50).'¦'; //17
                                    $txt .= $params->sujetoso->value.'¦'; //18
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->localidad->value), 0, 50).'¦'; //19
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->cp->value), 0, 25).'¦'; //20
                                    $txt .= substr(preg_replace('/\s+/', ' ', $prov_data->branch_code), 0, 50).'¦'; //21
                                    //$txt .= $params->pers->value.'¦'; //22
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->tel->value), 0, 15).'¦'; //22
                                    $txt .= '¦'; //23
                                    $txt .= 'AR¦'; //24
                                    $txt .= 'AR¦'; //25
                                    $txt .= 'ARS¦'; //26
                                    $txt .= date('dmY', strtotime($log->created_at)).'¦'; //27 definir bien esta fecha
                                    $txt .= $celular_data->elita.'¦'; //28 ojo porque este valor está al limite ??
                                    $txt .= '6¦'; //29
                                    $txt .= 'MOTOROLA¦'; //30
                                    $txt .= substr(preg_replace('/\s+/', ' ', $product->version), 0, 30).'¦'; //31
                                    $txt .= substr($params->imei->value, 0, 20).'¦'; //32
                                    $txt .= '1¦'; //33
                                    $txt .= '12¦'; //34
                                    $txt .= $product->precio_seguro.'¦'; //35
                                    $txt .= 'C¦'; //36
                                    $txt .= '¦¦'; //37-38
                                    $txt .= substr(preg_replace('/\s+/', ' ', $params->tnombres->value), 0, 50).'¦'; //39
                                    $txt .= $CC_INFO[$params->tcctype->value]['code'].'¦'; //40
                                    $txt .= $params->ntarjeta->value.'¦'; //41
                                    $txt .= substr($params->ftarjeta->value, 0, 2).'20'.substr($params->ftarjeta->value, 3, 2).'¦'; //42
                                    $txt .= '¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦¦'; //43-122
                                    $txt .= substr($params->sexo->value, 0, 1).'¦'; //123
                                    $txt .= substr($params->fnac->value, 6, 4).substr($params->fnac->value, 3, 2).substr($params->fnac->value, 0, 2).'¦'; //124
                                    $txt .= $params->estadocivil->value.'¦'; //125
                                    $txt .= 'AR¦'; //126
                                    $txt .= 'AR¦'; //127
                                    $txt .= $params->tncuit->value.'¦'; //128
                                    $txt .= $params->imei->value.'¦'; //129
                                    $txt .= $params->ocupacion->value.'¦'; //130

                                    Storage::append($file['dir']. $file['name'], Helper::utf8toansi($txt));

                                    // save log
                                    $data_log =  Models\CampaignLog::where('id', $log->id)->first() ?? false;
                                    if($data_log){
                                        $data_log->payment_verified = 1;
                                        $data_log->file = $file['name'];
                                        $data_log->save();
                                    }
                                    break;
                                }
                            }
                        }
                    }
                //}--> if solo para MP

            }
            // si se generó log
            if($log_count>0){
                $txt = 'HH¦'.$dealer->code.'¦'.date('ymd').'¦'.$log_count.'¦1¦';
                Storage::prepend($file['dir']. $file['name'], Helper::utf8toansi($txt));
            }
        }

        //Storage::disk('local')->put('file44.txt',  $fp);


       //dd($txt);

        //dd($data->count());



        //$logs = Log::all();


        /*

        $string_encoded = iconv( mb_detect_encoding( $txt ), 'Windows-1252', $txt );
        //dd(mb_detect_encoding( $txt ));
        /*
        foreach ($logs as $log) {
            $txt .= $logs->id;
            $txt .= "\n";
        }*/
        /*

        //offer the content of txt as a download (logs.txt)
        return response($string_encoded)
            ->withHeaders([
            'Content-Type' => 'application/txt',
            'Cache-Control' => 'no-store, no-cache',
            'Content-Transfer-Encoding' => 'binary',
            'Content-Description' => 'File Transfer',
            'Content-Disposition' => 'attachment; filename="logs.txt',
        ]);
        */

        //header('Content-disposition: attachment; filename='.$_GET['filename']);
        //header('Content-type: application/txt');

        //dd(33);
    }

    public function pruebas(){
        $count = 0;
        $inspcar = Models\InspectionCar::where('_id','8gfe4z81eoowckkgoogkkcg0')->first() ?? false;
        foreach ($inspcar->images()->get() as $image){
            //dd(Config::get('models.inspection-car.image.dir').$image->image);
            if (Storage::exists(Config::get('models.inspection-car.image.dir').$image->image)) {
                $count++;
            }
        }
        dd($count);
    }

    public function index(){
        //dd(Session::all());
        if(auth()->user()->password_changed==0){
            return redirect()->route('password-change');
        }else if(Session::has('role_name') && Session::get('role_name')=='error'){
            return redirect()->route('login-usuario-error');
        }else if(!Session::has('role_id') && count(session()->get('roles'))>1){
            return redirect()->route('login-role');
        }else if(Session::has('role_name') && Session::get('role_name')=='superadmin'){
            return view('/pages/admin/home/index', [
                'page_title' => 'Inicio',
                'page_description' => ' - Logueado como: '.Session::get('role_name').''
            ]);
        }else if(Session::has('role_name') && Session::get('role_name')=='usuario'){
            return view('/pages/usuario/home/index', [
                'page_title' => 'Inicio',
                'page_description' => ' - Logueado como: '.Session::get('role_name')
            ]);
        }
    }

    public function loginRole(){
        $pageConfigs = [
            'self' => [
                'layout' => 'blank'
            ]
        ];
        return view('/pages/login/login-role', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function loginRoleSelected(Request $request){
        $usuario = Models\Usuario::where('id', Auth::user()->id)->first() ?? false;
        if( $request->role_name == 'usuario' ){
            if($usuario->status!=1){
                return redirect()->route('login-usuario-error');
            }
        }
        //avatar
        if($usuario->image){
            Session::put(['avatar' => $usuario->image]);
        }else{
            Session::put(['avatar' => 'avatar.png']);
        }
        //role
        $role =  Models\Role::where('name', $request->role_name)->first() ?? false;
        Session::put(
            [
            'role_id' => $role->id,
            'role_name' => $role->name,
            'alerts' => ($role ? $role->alerts()->get() : false)
            ]
        );
        return redirect()->route('home');
    }

    public function loginRoleChange(){

        if(Session::has('role_id') && count(session()->get('roles'))>1){
            Session::forget(['role_id', 'role_name']);
            return redirect()->route('login-role');
        }else{
            return redirect()->back();
        }

    }

    public function passwordChange(){
        $pageConfigs = [
            'self' => [
                'layout' => 'blank'
            ]
        ];
        return view('/pages/login/password-change', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function passwordChangeStore(Request $request){

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return redirect()->back()->with('error', [ 1, 'No coincide la contraseña actual con la ingresada!']);
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            return redirect()->back()->with('error', [ 2, 'La nueva contraseña no puede ser igual a la actual!']);
        }

        if(!Helper::inputValidate($request->new_password, 'password', 6, 20, true)){
            return redirect()->back()->with('error', [ 2, 'Ingrese correctamente la nueva contraseña.']);
        }

        if($request->get('new_password') != $request->get('new_confirm_password')){
            return redirect()->back()->with('error', [ 3, 'La nueva contraseña y su confirmación no coinciden!']);
        }

        try{
            Models\Usuario::find(auth()->user()->id)->update(['password'=>Hash::make($request->new_password), 'password_changed'=>1]);
            return redirect()->route('home');
        }
        catch(\Exception $e){
            $this->guard()->logout();
            $request->session()->invalidate();
            return $this->loggedOut($request) ?: redirect('/login');
        }

    }

    public function loginUsuarioError(){
        $pageConfigs = [
            'self' => [
                'layout' => 'blank'
            ]
        ];
        return view('/pages/login/login-usuario-error', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    public function mailEnvio(){

        try{

            // Datos dinámicos
            $data = [
                'email'            => 'mosquera.leonidas@kopernicus.tech',
                'nombre'           => 'Mariano',
                'detalleCobertura' => 'Daño y Robo',
                'costoMensual'     => '25.580 por mes',
            ];
            
            // 1) Generar PDF desde Blade
            $pdf = Pdf::loadView('emails.certificado.html', $data)->setPaper('A4', 'portrait');
            // Si usás URLs externas en imágenes:
            // $pdf->setOption(['isRemoteEnabled' => true]);

            $pdfContent = $pdf->output();

            // 2) Guardar en storage/app/certificados/
            $filename = 'Solicitud-de-compra-'.date('YmdHis').'.pdf';
            $path = 'certificados/'.$filename; // relativo a storage/app
            Storage::put($path, $pdfContent);

            // 3) Enviar mail con HTML + adjuntar PDF
            $subject = '¡Gracias! Hemos recibido tu solicitud de compra';
            $from = '';
            $from_name = 'Protección Motocare';
            $bcc  = '';

            switch (self::sendmail()['type']) {
                case 'local':

                    $from = self::sendmail()['local']['from'];
                    $bcc  = self::sendmail()['local']['bcc'];
                    Mail::to($data['email'])
                        ->bcc($bcc)
                        ->send(new CertificadoHTML(
                            [
                                'nombre'           => $data['nombre'],
                                'detalleCobertura' => $data['detalleCobertura'],
                                'costoMensual'     => $data['costoMensual'],
                            ],
                            $pdfContent,       // $pdfContent
                            $filename,         // $pdfFilename
                            null,              // $pdfStoragePath (no lo usás)
                            $subject,          // $mailSubject
                            $from,             // $fromAddress
                            $from_name         // $fromName
                    ));
                    break;

                case 'mailersend':

                    $from = self::sendmail()['mailersend']['proteccion-motocare']['from'];
                    $bcc  = self::sendmail()['mailersend']['proteccion-motocare']['bcc'];
                    $ms = new MailerSend([
                        'api_key' => self::sendmail()['mailersend']['proteccion-motocare']['type'] == 'prod' ? self::sendmail()['mailersend']['proteccion-motocare']['token_prod'] : self::sendmail()['mailersend']['proteccion-motocare']['token_dev']
                    ]);

                    // Renderizar el HTML del Blade a string (igual que tu mailable)
                    $html = view('emails.certificado.html', [
                        'nombre'           => $data['nombre'],
                        'detalleCobertura' => $data['detalleCobertura'],
                        'costoMensual'     => $data['costoMensual'],
                    ])->render();

                    // Destinatarios
                    $to  = [ new Recipient($data['email'], '') ];
                    $bcc = [ new Recipient($bcc, '') ];

                    // Adjuntar el PDF (usa el binario que ya generaste)
                    $attachments = [
                        new MsAttachment($pdfContent, $filename) // MIME se infiere; opcionalmente podés setearlo
                    ];

                    $email = (new EmailParams())
                        ->setFrom($from)
                        ->setFromName($from_name)
                        ->setRecipients($to)
                        ->setBcc($bcc)
                        ->setSubject($subject)
                        ->setHtml($html)
                        ->setAttachments($attachments);

                    $ms->email->send($email);
                    break;
            }

            return "Mensaje enviado";
        }
        catch(\Exception $e){
            //return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            dd($e);
        }
    }

    public function exit(){
        return redirect()->route('error-404');
    }
}
