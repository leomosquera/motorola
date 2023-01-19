<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Helpers\Helper;
use App\Models;
use Storage;

class HomeController extends Controller
{

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
