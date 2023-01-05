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
        $now = Carbon::now()->format('Y-m-d H:i:s');
        $data = Models\Campaign::
        where('usuario_id', auth('api')->user()->id)
            ->where('id', $id)
            ->where('status', 1)
            ->whereDate('date_start', '<=', $now)
            ->whereDate('date_end', '>=', $now)
            ->first() ?? false;

        //store / tienda
        $store = Models\Store::where('uniqueid', $request->store)->first() ?? false;

        if($data && $store)
            return $this->successResponse($data,'Campaña encontrada', 302);
        else
            return $this->errorResponse('Campaña no encontrada', 404);
    }
}
