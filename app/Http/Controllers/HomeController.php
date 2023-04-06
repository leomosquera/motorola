<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models;
use Storage;

class HomeController extends Controller
{

    public function storesQr(){
        //stores
        $stores = Models\Store::where('status',1)
        ->orderBy('dealer_id','ASC')
        ->orderBy('code','ASC');

        $info_store = [];
        foreach ($stores->get() as $store){
            //genero la url de QR
            $url = 'https://proteccionmobile.com.ar/?'.base64_encode($store->uniqueid);
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

    public function productsMigration(){
        $json = Storage::get('base/migration/update.json');
        $json = json_decode($json, true);

        foreach ($json as $valor){
            if (array_key_exists('Product SKU', $valor)) {

                $data   = Models\Product::where('sku', $valor['Product SKU'])->first() ?? false;
                $family = Models\ProductFamily::where('name', $valor['Product Name'])->first() ?? false;

                //Actualizacion Familias
                if(!$family){
                    $family = new Models\ProductFamily();
                    $family->name = $valor['Product Name'];
                    $family->save();
                }

                //Actualizacion Productos
                if(!$data){
                    $data = new Models\Product();
                }

                $data->product_type_id = 1;
                $data->product_family_id = $family->id;
                $data->status = trim($valor['DISCONTINUADOS']) == 'OK' && (float)$valor['PRECIO BRUTO EQUIPO'] > 0 && (float)$valor['PRECIO MINIMO'] > 0 && (float)$valor['PRECIO MAXIMO'] > 0 && (float)$valor['PREMIO ABM INTERNO'] > 0 && (float)$valor['Precio Seguro Actualizado'] > 0 && (float)$valor['DEDUCIBLE'] > 0 ? 1 : 0;
                $data->sku = $valor['Product SKU'];
                $data->elita = $valor['PRODUCT CODE ELITA'];
                $data->name = $valor['Product Name'];
                $data->description = $valor['Product Description'];
                $data->save();

                $data_price = new Models\ProductPrice();
                $data_price->product_id = $data->id;
                $data_price->coverage = $valor['Cobertura'];
                $data_price->duration = $valor['Duracion'];
                $data_price->idnewsanmotocare = strlen($valor['ID Newsan Motocare']) > 0 ? $valor['ID Newsan Motocare'] : Str::uuid()->toString();
                $data_price->price_gross = (float)$valor['PRECIO BRUTO EQUIPO'];
                $data_price->price_min = (float)$valor['PRECIO MINIMO'];
                $data_price->price_max = (float)$valor['PRECIO MAXIMO'];
                $data_price->price_abm = (float)$valor['PREMIO ABM INTERNO'];
                $data_price->price_insured = (float)$valor['Precio Seguro Actualizado'];
                $data_price->price_deductible = (float)$valor['DEDUCIBLE'];
                $data_price->save();

            }
        }
    }

    public function storesHistorySales(){

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
                if(Helper::mpPaymentUpdateAllStatusByStore($store->id)){
                    //selector de log para crear file
                    $data =  Models\CampaignLog::
                    where('store_id', $store->id)
                    ->where('payment_code', 'MP')
                    ->where('event', 'payment_approved')
                    ->where('file',null)
                    ->where('created_at', '>=', Carbon::now()->subDays(config('global.log.subdays')))
                    ->orderBy('id', 'DESC')
                    ->with('store');

                    if($data->count() > 0){
                        //mpPaymentApproved
                        $log_count += $data->count();
                        foreach ($data->get() as $log){
                            $params   = json_decode($log->params);
                            $services = json_decode($log->services);
                            //dd($log->id);
                            //busco en los productos el elegido
                            foreach ($services->products->data as $product){
                                //busco en la informacion de los precios
                                foreach ($product->prices as $price){
                                    //el producto que coincide con el guardado en params es el elegido
                                    if($params->codarticulo->value == $price->idnewsanmotocare){
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
                                        Storage::append($file['dir']. $file['name'], Helper::utf8toansi($txt));

                                        // save log
                                        $data_log =  Models\CampaignLog::where('id', $log->id)->first() ?? false;
                                        if($data_log){
                                            $data_log->payment_verified = 1;
                                            $data_log->file = $file['name'];
                                            $data_log->save();
                                        }
                                        break 2;
                                    }
                                }
                            }
                        }
                    }
                }

            }
            // si se generó log
            if($log_count>0){
                $txt = 'HH¦'.$dealer->code.'¦'.date('ymd').'¦'.$log_count.'¦1';
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

    public function exit(){
        return redirect()->route('error-404');
    }
}
