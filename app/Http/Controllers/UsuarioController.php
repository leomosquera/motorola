<?php

namespace App\Http\Controllers;

use App\Models;
use Illuminate\Http\Request;
use App\Http\Requests\ValidationUsuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Hash;
use Storage;
use Config;
use Datatables;

class UsuarioController extends Controller
{
    //Filters indexDt
    private function filter_namelastname()
    {
        return 'CONCAT(usuarios.name, " ", usuarios.lastname)';
    }

    private function filter_roles()
    {
        return '(
            SELECT
            GROUP_CONCAT(roles.name SEPARATOR ", ")
            FROM usuario_role
            JOIN roles
            ON roles.id = usuario_role.role_id
            WHERE usuario_role.usuario_id = usuarios.id
        )';
    }

    private function filter_history_logged()
    {
        return '(
            SELECT
            COUNT(DISTINCT(usuario_history.id))
            FROM usuario_history
            WHERE
            usuario_history.usuario_id = usuarios.id
            AND usuario_history.type = ' . Config::get('models.usuario.history.type')['logged'] . '
        )';
    }

    public function index()
    {
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => false, 'title' => 'Lista de Usuarios']
        ];
        return view('pages/admin/usuario/index', [
            'page_title' => 'Usuarios',
            'page_breadcrumbs' => $page_breadcrumbs
        ]);
    }

    public function indexDt(Request $request)
    {
        if ($request->ajax()) {
            $usuarios = Models\Usuario::query()
                ->selectRaw('
                usuarios.*,
                ' . $this->filter_namelastname() . ' as namelastname,
                ' . $this->filter_roles() . ' as roles,
                ' . $this->filter_history_logged() . ' as history_logged
                ')
                ->groupBy('usuarios.id');
            return DataTables::of($usuarios)
                ->filterColumn('namelastname', function ($query, $keyword) {
                    $query->whereRaw($this->filter_namelastname() . " like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('roles', function ($query, $keyword) {
                    $query->whereRaw($this->filter_roles() . " like ?", ["%{$keyword}%"]);
                })
                ->filterColumn('history_logged', function ($query, $keyword) {
                    $query->whereRaw($this->filter_history_logged() . " like ?", ["%{$keyword}%"]);
                })
                ->addColumn('password_changed_status', '<span class="switch switch-sm"><label><input type="checkbox" data-route="{{ route(\'usuario-password-changed\') }}" data-action="status" data-id="{{$id}}" {{$password_changed==1?"checked":""}}><span></span></label></span>')
                ->addColumn('action', '<a href="{{ route(\'usuario-edit\', $id) }}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" data-placement="top" title="Editar"><i class="la la-edit"></i></a> <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-route="{{ route(\'usuario-destroy\') }}" data-action="delete" data-id="{{$id}}" data-question="Desea eliminar el usuario &quot;{{ $name.\' \'.$lastname }}&quot; ?" data-toggle="tooltip" data-placement="top" title="Borrar"><i class="la la-trash"></i></a>')
                ->rawColumns(['password_changed_status', 'action'])
                ->make(true);
        } else {
            abort(404);
        }
    }

    public function create()
    {
        $roles = Models\Role::all();
        $page_breadcrumbs = [
            ['page' => '/', 'title' => 'Home'], ['page' => 'admin/usuario', 'title' => 'Lista de Usuarios'], ['page' => false, 'title' => 'Crear usuario']
        ];
        return view('pages/admin/usuario/create', [
            'page_title' => 'Crear Usuario',
            'page_breadcrumbs' => $page_breadcrumbs,
            'roles' => $roles,
            'action' => 'create'
        ]);
    }

    public function store(ValidationUsuario $request){
        try{
          //dd($request);
          $usuario = new Models\Usuario;
          $usuario->username = $request->username;
          $usuario->name = $request->name;
          $usuario->lastname = $request->lastname;
          $usuario->email = $request->email;
          $usuario->password = Hash::make($request->password);
          $usuario->password_changed = $request->password_changed;
          $usuario->image = Models\Usuario::setUsuarioAvatar($request->image_up, null, $request->image_delete);
          $usuario->save();
          $usuario->roles()->attach($request->roles);
          return redirect()->route('usuario')->with('response',['success','Correctamente!','Se agregó un Usuario']);
        }
        catch(\Exception $e){
            return redirect()->route('usuario')->with('response',['error','Error',$e->getMessage()]);
        }
    }

    public function edit( $id = 0 ){
        $data = Models\Usuario::where('id', $id)->first() ?? false;
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

    public function update(ValidationUsuario $request, $id){
        try{
            $data = Models\Usuario::findOrFail($id);
            if($data->id!=1){
              $data->username = $request->username;
            }
            $data->email = $request->email;
            $data->name = $request->name;
            $data->lastname = $request->lastname;
            if($request->password_change_confirm == 1){
                $data->password = Hash::make($request->password);
            }
            $data->password_changed = $request->password_changed;
            $data->image = Models\Usuario::setUsuarioAvatar($request->image_up, $data->image, $request->image_delete);
            $data->save();
            $data->roles()->sync($request->roles);
            // Avatar
            if($data->id==Auth::user()->id){
                if($data->image){
                    Session::put(['avatar' => $data->image]);
                }else{
                    Session::put(['avatar' => 'avatar.png']);
                }
            }
            return redirect()->route('usuario')->with('response',['success','Correctamente!','Se modificó el Usuario']);
        }
        catch(\Exception $e){
            return redirect()->route('usuario')->with('response',['error','Error',$e->getMessage()]);
        }
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Models\Usuario::where('id', $request->id)->where('id', '!=', 1)->first() ?? false;
                if ($data) {
                    $data->roles()->sync([]);
                    if ($data->delete())
                        Storage::disk('public')->delete(Config::get('models.usuario.avatar.dir').$data->image);
                    return \Response::json(array('response' => ['success', 'Correctamente!', 'Se borró el Usuario!']));
                } else {
                    return \Response::json(array('response' => ['error', 'Error!', 'El Usuario no puede eliminarse.']));
                }
            } catch (\Exception $e) {
                return \Response::json(array('response' => ['error', 'Error', $e->getMessage()]));
            }
        } else {
            abort(404);
        }
    }

    public function passwordChanged(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Models\Usuario::where('id', $request->id)->first() ?? false;
                if ($data) {
                    $data->password_changed = $request->status;
                    $data->save();
                    return \Response::json(array('response' => ['success', 'Correctamente!', 'El usuario ' . ($request->status == 1 ? 'ya modificó su Contraseña!' : 'deberá modificar su Contraseña en su próximo acceso!')]));
                } else {
                    return \Response::json(array('response' => ['error', 'Error!', 'No pudo actualizarse el estado de modificación de Contraseña']));
                }
            } catch (\Exception $e) {
                return \Response::json(array('response' => ['error', 'Error!', 'No se modificó el estado de modificación de Contraseña']));
            }
        } else {
            abort(404);
        }
    }
}
