<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAccountController extends Controller
{
    public function edit(){
        $data = Models\Usuario::where('id', Auth::user()->id)->first() ?? false;
        $data_roles = $data->roles()->pluck('id')->toArray();
        $roles = Models\Role::all();
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => 'admin/usuario', 'title' => 'Lista de Usuarios'], ['page' => false, 'title' => 'Editar usuario']
        ];
        return view('pages/admin/usuario/edit', [
            'page_title' => 'Editar Usuario',
            'page_breadcrumbs' => $page_breadcrumbs,
            'data' => $data,
            'data_roles' => $data_roles,
            'roles' => $roles,
            'action' => 'edit'
        ]);
    }
}
