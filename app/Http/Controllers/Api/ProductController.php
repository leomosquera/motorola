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
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
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
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function productPriceByIdnew($idnew = null, Request $request){
        try{

            $data = Models\ProductPrice::query()
            ->join('coverages as cv', function($join) {
                $join->on('cv.code', '=', 'product_price.coverage')
                ->on('cv.duration', '=', 'product_price.duration');
            })
            ->where('idnewsanmotocare', urldecode($idnew))
            ->selectRaw('
            product_price.coverage,
            product_price.duration,
            product_price.idnewsanmotocare,
            product_price.price_gross,
            product_price.price_insured,
            product_price.price_deductible,
            cv.title as coverage_title,
            cv.payment_type as coverage_payment_type,
            cv.description as coverage_description
            ') ?? false;

            $mp = Models\MpStatus::where('id', '>', 0);

            if($data){
                return $this->successResponse($data->get(),'Lista de productos', 302);
            }else{
                return $this->errorResponse('Sin productos', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

}
