<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Helper;
use Config;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        $pageConfigs = [
            'self' => [
                'layout' => 'blank'
            ]
        ];
        return view('/pages/login/login', [
            'pageConfigs' => $pageConfigs
        ]);
    }

    protected function authenticated(Request $request, $user)
    {
        //Helper::usuarioHistory($user->id, Config::get('usuario_history.type')['logged']);
        //$this->setUserSession($user);
        $roles = $user->roles()->get();
        if ($roles->isNotEmpty()) {
            Session::put('roles',$roles->toArray());
            //dd(count(session()->get('roles')));
            //dd(auth()->user());
            //dd(session()->all());
            if (auth()->user()->password_changed == 0) {
                return redirect()->route('password-change');
            } else if (Session::has('role_name') && Session::get('role_name') == 'error') {
                $pageConfigs = [
                    'bodyClass' => "bg-full-screen-image",
                    'blankPage' => true
                ];
                return view('/security/login-usuario-error', [
                    'pageConfigs' => $pageConfigs
                ]);
            } else if (!Session::has('role_id') && count(Session::get('roles')) > 1) {
                $pageConfigs = [
                    'self' => [
                        'layout' => 'blank'
                    ]
                ];
                return view('/pages/login/login-role', [
                    'pageConfigs' => $pageConfigs
                ]);
            } else if (Session::has('role_name') && Session::get('role_name') == 'superadmin') {
                $pageConfigs = [
                    'bodyClass' => "bg-full-screen-dealer ecommerce-application",
                    'pageHeader' => false
                ];
                return view('/pages/home-superadmin', [
                    'pageConfigs' => $pageConfigs
                ]);
            } else if (Session::has('role_name') && Session::get('role_name') == 'dealer') {
                $pageConfigs = [
                    'bodyClass' => "bg-full-screen-dealer ecommerce-application",
                    'pageHeader' => false
                ];
                return view('/pages/home-dealer', [
                    'pageConfigs' => $pageConfigs
                ]);
            }
        } else {
            $this->guard()->logout();
            $request->session()->invalidate();
            return redirect('security/login')->with('toastr', ['error', 'Error', 'El usuario no tiene un rol activo', 'toast-login-top-center']);
        }
    }

    public function username()
    {
        return 'username';
    }
}
