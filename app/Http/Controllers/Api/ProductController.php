<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models;

class ProductController extends ApiController
{
    public function productName(Request $request){
        try{

            $data = Models\Product::where('status', 1)
                ->distinct('name')
                ->orderBy('name', 'ASC')
                ->select('name')
                ?? false;
            if($data){
                return $this->successResponse($data->get(),'Lista de productos', 302);
            }else{
                return $this->errorResponse('Sin productos', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error se sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function productByName($name = null, Request $request){
        try{

            $data = Models\Product::where('status', 1)
            ->where('name', urldecode($name))
            ->distinct('sku')
            ->orderBy('name', 'ASC')
            ->with('prices')
            ?? false;

            if($data){
                return $this->successResponse($data->get(),'Lista de productos', 302);
            }else{
                return $this->errorResponse('Sin productos', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error se sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

}
