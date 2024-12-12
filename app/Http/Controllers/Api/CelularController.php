<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Celular;


class CelularController extends ApiController
{
    public function modelos(Request $request)
    {
        try{
            $data = Celular::distinct()->select('name')->where('status', 1)->groupBy('name');
            //dd($data);
            if($data)
                return $this->successResponse($data->get(),'Resultado encontrado', 302);
            else
                return $this->errorResponse('Resultado no encontrado', 404);
        }
        catch(\Exception $e){
            return $this->errorResponse('Error en servicios.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function versiones(Request $request)
    {
        try{
            $data = Celular::distinct()->select('version')->where('status', 1)->where('name',$request->modelo)->groupBy('version');
            //dd($data->get());
            if($data)
                return $this->successResponse($data->get(),'Campaña encontrada', 302);
            else
                return $this->errorResponse('Campaña no encontrada', 404);
        }
        catch(\Exception $e){
            return $this->errorResponse('Error en servicios.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function coberturas(Request $request)
    {
        try{
            $data = Celular::select('code', 'version', 'cobertura', 'precio_bruto_equipo', 'precio_seguro')
            ->where('status', 1)
            ->where('name', $request->modelo)
            ->where('version', $request->version)
            ->groupBy('code')
            ->orderBy('precio_seguro', 'ASC');
            //dd($data->get());
            if($data)
                return $this->successResponse($data->get(),'Campaña encontrada', 302);
            else
                return $this->errorResponse('Campaña no encontrada', 404);
        }
        catch(\Exception $e){
            return $this->errorResponse('Error en servicios.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

}
