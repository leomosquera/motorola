<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PermissionSuperadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->permiso())
            return $next($request);

        return redirect('/exit')->with('mensaje', 'No tiene permiso para entrar aquí');
    }

    private function permiso()
    {
        if(Session::has('role_id')){
            return Session::get('role_name') == 'superadmin';
        }
        /*
            $collRoles = collect(Session::get('roles'));
            return in_array('superadmin',$collRoles->pluck('name')->toArray());
        }
        */
    }
}
