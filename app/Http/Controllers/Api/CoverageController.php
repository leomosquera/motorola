<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models;

class CoverageController extends ApiController
{
    public function info(Request $request){
        try{

            $data = Models\Coverage::where('status', 1)
                ->orderBy('id', 'ASC')
                ->select('code','title','duration','payment_type','description')
                ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de coberturas', 302);
            }else{
                return $this->errorResponse('Sin coberturas', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }
}
