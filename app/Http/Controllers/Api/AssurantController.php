<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models\Assurant;
use App\Models\Store;

class AssurantController extends ApiController
{
    public function provincias(Request $request){
        try{

            $data = Assurant\Provincia::
            where('status', 1)
            ->orderBy('nombre', 'ASC')
            ->select('cod', 'nombre')
            ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de provincias', 302);
            }else{
                return $this->errorResponse('Sin provincias', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function localidades($code = null, Request $request){
        try{

            $data = Assurant\Localidad::where('provincia_cod', $code)
            ->where('status', 1)
            ->orderBy('nombre', 'ASC')
            ->select('cod', 'nombre','cp')
            ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de localidades', 302);
            }else{
                return $this->errorResponse('Sin localidades', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function estadocivil(Request $request){
        try{
            $data = Assurant\EstadoCivil::orderBy('id', 'ASC')
            ->select('cod', 'desc')
            ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de estado civil', 302);
            }else{
                return $this->errorResponse('Sin estado civil', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function sexo(Request $request){
        try{
            $data = Assurant\Sexo::orderBy('id', 'ASC')
            ->select('cod', 'desc')
            ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de sexo', 302);
            }else{
                return $this->errorResponse('Sin sexo', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function stores(Request $request){
        try{
            $data = Store::orderBy('name', 'ASC')
            ->where('status', 1)
            ->select('name', 'uniqueid', 'code')
            ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de kioskos', 302);
            }else{
                return $this->errorResponse('Sin sexo', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }
}
