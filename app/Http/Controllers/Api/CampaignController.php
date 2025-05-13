<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models;

class CampaignController extends ApiController
{
    public function campaign($id = null, $store = null, Request $request)
    {
        /* Tipo de acceso */
        // 'none'    // sin validación en la url
        // 'unique'  // que existe un unico id en la url
        // 'bystore' // se valida que el store exista en la url
        $configAccess = 'none';
        $access = false;
        
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $data = Models\Campaign::
        where('usuario_id', auth('api')->user()->id)
            ->where('id', $id)
            ->where('status', 1)
            ->whereDate('date_start', '<=', $now)
            ->whereDate('date_end', '>=', $now)
            ->select('id', 'name', 'date_start', 'date_end')
            ->first() ?? false;

        //store / tienda
        $store = Models\Store::where('uniqueid', $request->store)->first() ?? false;

        //valido segun tipo de acceso
        switch ($configAccess) {
            case 'none':
                $access = true;
                $response = [
                    'campaign' => $data
                ];
                break;

            case 'unique':
                $access = true;
                $response = [
                    'campaign' => $data,
                    'unique'   => 'motocareuniqueid'
                ];
                break;

            case 'bystore':
                $access = $store ? true : false;
                $response = [
                    'campaign' => $data,
                    'store'    => base64_encode($store->code),
                ];
                break;
        }

        if($data && $access){
            return $this->successResponse($response,'Campaña encontrada', 302);
        }else{
            return $this->errorResponse('Campaña no encontrada', 404);
        }
    }
}
