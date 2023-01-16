<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models;

class CampaignLogController extends ApiController
{
    public function store(Request $request){
        try{
            //campaña pertenece al usuario?
            $data = Models\Campaign::where('id', $request->campaign_id)->where('usuario_id', auth('api')->user()->id)->first() ?? false;
            //store / tienda
            $store = Models\Store::where('uniqueid', $request->store)->first() ?? false;
            if($data && $store){
                //valido request
                $request->params = json_encode($request->params);
                $validator = Validator::make($request->all(), [
                    'store'               => 'required|max:100',
                    'campaign_id'         => 'required|integer',
                    'campaign_info'       => 'required',
                    'id_log'              => 'required|max:100',
                    'url_referer_encrypt' => 'required|max:1000',
                    'url_referer_decrypt' => 'required|max:1000',
                    'params'              => 'required',
                    'event'               => 'required|max:30',
                    'ip_info'             => 'required|max:100'
                ]);

                if(!$validator->fails()){
                    //guardo log
                    $campaignlog =                    new Models\CampaignLog();
                    $campaignlog->usuario_id          = auth('api')->user()->id;
                    $campaignlog->campaign_id         = $request->campaign_id;
                    $campaignlog->store_id            = $store->id;
                    $campaignlog->campaign_info       = $request->campaign_info;
                    $campaignlog->id_log              = $request->id_log;
                    $campaignlog->payment_code        = strpos($request->event, 'payment') !== false ? 'MP' : null;
                    $campaignlog->url_referer_encrypt = $request->url_referer_encrypt;
                    $campaignlog->url_referer_decrypt = $request->url_referer_decrypt;
                    $campaignlog->body                = $request->body;
                    $campaignlog->services            = $request->services;
                    $campaignlog->params              = $request->params;
                    $campaignlog->event               = $request->event;
                    $campaignlog->ip_info             = $request->ip_info;
                    $campaignlog->save();
                    return $this->successResponse($validator->fails(),'Log guardado.', 201);
                }else{
                    return $this->errorResponse($validator->errors(), 404);
                }
            }else{
                return $this->errorResponse('La campaña no fue encontrada o no pertenece a este usuario.', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function update(Request $request){
        try{
            $data = Models\CampaignLog::
            where('usuario_id', auth('api')->user()->id)
                ->where('campaign_id', $request->campaign_id)
                ->where('id_log',      $request->id_log)
                ->where('event',       $request->event)
                ->orderBy('created_at', 'DESC')
                ->first() ?? false;
            if($data){
                $validator = Validator::make($request->all(), [
                    'campaign_info'       => 'required'
                ]);
                if(!$validator->fails()){
                    //modifico log
                    $data->campaign_info = $request->campaign_info;
                    $data->save();
                    return $this->successResponse($validator->fails(),'Log modificado.', 201);
                }else{
                    return $this->errorResponse($validator->errors(), 404);
                }
            }else{
                return $this->errorResponse('Log no modificado', 404);
            }

        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function info(Request $request){
        try{
            $data = Models\CampaignLog::
            where('usuario_id', auth('api')->user()->id)
                ->where('campaign_id', $request->campaign_id)
                ->where('id_log', $request->id_log)
                ->orderBy('created_at', 'DESC')
                ->first() ?? false;
            if($data){
                $data->params   = json_decode($data->params,true);
                $data->services = json_decode($data->services,true);
                return $this->successResponse($data,'Log encontrado', 302);
            }else{
                return $this->errorResponse('Log no encontrado', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function infoByIdlog($id_log = null, Request $request){
        try{
            $data = Models\CampaignLog::
            where('id_log', urldecode($request->id_log))
                ->orderBy('created_at', 'DESC')
                ->first() ?? false;
            if($data){
                $data->params   = json_decode($data->params,true);
                $data->services = json_decode($data->services,true);
                return $this->successResponse($data,'Log encontrado', 302);
            }else{
                return $this->errorResponse('Log no encontrado', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function payment(Request $request){
        try{
            //log by id_log
            $exist = Models\CampaignLog::where('id_log', $request->id_log)->where(function($query) {
                $query->where('event','payment_approved');
            })->latest()->first() ?? false;                
            
            if(!$exist){
                $data  = Models\CampaignLog::where('id_log', $request->id_log)->latest()->first() ?? false;
                if($data){
                    //guardo respuesta de la pasarela de pago
                    $services = json_decode($data->services,true);
                    $services['payment'] = $request->services;
                    //guardo log
                    $campaignlog =                    new Models\CampaignLog();
                    $campaignlog->usuario_id          = auth('api')->user()->id;
                    $campaignlog->campaign_id         = $data->campaign_id;
                    $campaignlog->store_id            = $data->store_id;
                    $campaignlog->campaign_info       = $data->campaign_info;
                    $campaignlog->id_log              = $data->id_log;
                    $campaignlog->payment_code        = $data->payment_code;
                    $campaignlog->url_referer_encrypt = $data->url_referer_encrypt;
                    $campaignlog->url_referer_decrypt = $data->url_referer_decrypt;
                    $campaignlog->body                = null;
                    $campaignlog->services            = json_encode($services);
                    $campaignlog->params              = $data->params;
                    $campaignlog->event               = 'payment_'.$request->status;
                    $campaignlog->ip_info             = $data->ip_info;
                    $campaignlog->save();
                    return $this->successResponse(true,'Log guardado.', 201);
                }else{
                    return $this->errorResponse('El log no fue encontrado o no pertenece a este usuario.', 404);
                }
            }else{
                return $this->errorResponse('El pago para esta operación ya fue procesado.', 404);
            }
        }
        catch(\Exception $e){
            return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            //return $this->errorResponse($e, 404);
        }
    }

    public function imagesUpload(Request $request){
        try{
            $allowedfileExtension=['jpg','png'];
            if($request->hasFile('photo') && $request->has('id_log')) {
                $image     = $request->file('photo');
                $extension = $image->getClientOriginalExtension();
                $fileName  = $request->id_log.'-'.date('YmdHis').'-'.uniqid().'.'.$extension;
                if(in_array($extension,$allowedfileExtension)){
                    $destinationPath = base_path() . '/public/storage/uploads/campaign/log/' . $request->id_log;
                    $image->move($destinationPath, $fileName);
                    $attributes['image'] = $fileName;
                }
            }
            return $this->successResponse($fileName,'Imagen almacenada', 302);
        }
        catch(\Exception $e){
            return $this->errorResponse('Error en la subida de imágenes.', 404);
            //return $this->errorResponse($e, 404);
        }
    }
}
