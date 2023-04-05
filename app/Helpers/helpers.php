<?php // Code within app\Helpers\Helper.php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
use Intervention\Image\ImageManagerStatic as FileImage;
use App\Models;
use GuzzleHttp\Client;
use Storage;

class Helper
{
    // Mercado Pago Buscar si el pago está aprobado según preference_id
    public static function mpPaymentGetInfo($params = null){
        $required = array('collection_id', 'collection_status', 'payment_id', 'status', 'merchant_order_id', 'preference_id', 'site_id');
        if (count(array_intersect_key(array_flip($required), (array) $params)) === count($required)) {
            // All required keys exist!
            return [
                'collection_id'       => $params->collection_id,
                'collection_status'   => $params->collection_status,
                'payment_id'          => $params->payment_id,
                'status'              => $params->status,
                'merchant_order_id'   => $params->merchant_order_id,
                'preference_id'       => $params->preference_id,
                'site_id'             => $params->site_id
            ];
        }else{
            return null;
        }
    }

    // Mercado Pago guarda el estado del pago en el log
    public static function logPaymentSaveStatus($id=null, $params=null){
        $resp = false;
        if($id!=null && $params!=null){
            $data  = Models\CampaignLog::
            where('id', $id)
            ->where('event', 'payment_init')
            ->latest()
            ->first() ?? false;

            if($data){
                //guardo respuesta de la pasarela de pago
                $services = json_decode($data->services,true);
                $services['payment'] = Helper::mpPaymentGetInfo($params);
                //guardo log
                $campaignlog =                    new Models\CampaignLog();
                $campaignlog->usuario_id          = 1;
                $campaignlog->campaign_id         = $data->campaign_id;
                $campaignlog->store_id            = $data->store_id;
                $campaignlog->campaign_info       = $data->campaign_info;
                $campaignlog->id_log              = $data->id_log;
                $campaignlog->payment_code        = $data->payment_code;
                $campaignlog->payment_verified    = 1;
                $campaignlog->url_referer_encrypt = $data->url_referer_encrypt;
                $campaignlog->url_referer_decrypt = $data->url_referer_decrypt;
                $campaignlog->body                = null;
                $campaignlog->services            = json_encode($services);
                $campaignlog->params              = $data->params;
                $campaignlog->event               = 'payment_'.$params->status;
                $campaignlog->ip_info             = $data->ip_info;
                $campaignlog->save();
                //indico que el pago fue verificado desde el estado payment_init
                $data->payment_verified = 1;
                $data->save();
                //
                $resp = $params->status;
            }else{
                $resp = false;
            }
        }
        return $resp;
    }

    // Mercado Pago Buscar si el pago está aprobado según preference_id
    public static function mpPaymentApproved($preference_id = '*'){
        try {
            $client = new Client();
            $response = $client->request('GET', config('services.mercadopago.api').'merchant_orders/search', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer '.config('services.mercadopago.token')
                ],
                'query' => [
                        'preference_id' => $preference_id
                ]
            ]);
            //obtengo y guardo log
            $response_statuscode = $response->getStatusCode();
            $response_contents   = json_decode($response->getBody()->getContents());
            if($response_statuscode == 200 && $response_contents->elements !== null){
                $status = false;
                if(count($response_contents->elements)>0){
                    //busco en todos los elementos
                    foreach ($response_contents->elements as $element){
                        if(count($element->payments)>0){
                            //busco que todos los pagos estén aprobados en el elemento
                            foreach ($element->payments as $payment){
                                if($payment->status == 'approved'){
                                    $status = true;
                                    break;
                                }
                            }
                        }else{
                            return false;
                        }
                    }
                    return $status;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        } catch (Exception $e) {
            //return \Response::json(array('status' => ['404',$e->getMessage()]));
            return false;
        }
    }

    // Mercado Pago Buscar según preference_id y traer el ultimo estado
    public static function mpPaymentLastStatus($preference_id = '*'){
        try {
            $client = new Client();
            $response = $client->request('GET', config('services.mercadopago.api').'merchant_orders/search', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer '.config('services.mercadopago.token')
                ],
                'query' => [
                        'preference_id' => $preference_id
                ]
            ]);
            //obtengo y guardo log
            $response_statuscode = $response->getStatusCode();
            $response_contents   = json_decode($response->getBody()->getContents());
            if($response_statuscode == 200 && $response_contents->elements !== null){
                $status = false;
                if(count($response_contents->elements)>0){
                    //busco en todos los elementos
                    foreach ($response_contents->elements as $element){
                        if(count($element->payments)>0){
                            //busco que todos los pagos estén aprobados en el elemento
                            foreach ($element->payments as $payment){
                                $status = $payment->status;
                            }
                        }else{
                            return false;
                        }
                    }
                    return $status;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        } catch (Exception $e) {
            //return \Response::json(array('status' => ['404',$e->getMessage()]));
            return false;
        }
    }

    //Realizo un update de todos los logs segun store
    public static function mpPaymentUpdateAllStatusByStore($store_id){
        $res = false;
        $data =  Models\CampaignLog::
        where('store_id', $store_id)
        ->where('payment_code', 'MP')
        ->where('event', 'payment_init')
        ->withCount('file_register')
        ->where('created_at', '>=', Carbon::now()->subDays(config('global.log.subdays')))
        ->orderBy('id', 'DESC')
        ->with('store');

        if($data->count() > 0){
            foreach ($data->get() as $log){
                if($log->file_register_count == 0){
                    $log_body = json_decode($log->body);
                    $res = Helper::mpPaymentUpdateAllStatus($log->id,$log_body->ref);
                }
            }
        }
        return $res;
    }

    // Mercado Pago Buscar según preference_id y traer el ultimo estado
    public static function mpPaymentUpdateAllStatus($id, $preference_id = '*'){
        try {
            $client = new Client();
            $response = $client->request('GET', config('services.mercadopago.api').'merchant_orders/search', [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'Bearer '.config('services.mercadopago.token')
                ],
                'query' => [
                        'preference_id' => $preference_id
                ]
            ]);
            //obtengo y guardo log
            $response_statuscode = $response->getStatusCode();
            $response_contents   = json_decode($response->getBody()->getContents());
            if($response_statuscode == 200 && $response_contents->elements !== null){
                if(count($response_contents->elements)>0){
                    //busco en todos los elementos
                    foreach ($response_contents->elements as $element){
                        if(count($element->payments)>0){
                            //busco que todos los pagos
                            foreach ($element->payments as $payment){

                                //obtengo id_log
                                $data_log = Models\CampaignLog::where('id', $id)
                                ->first() ?? false;

                                if($data_log !== false){
                                    //busco en base si esta registrado
                                    $data = Models\CampaignLog::where('id_log', $data_log->id_log)
                                    ->whereJsonContains('services', ['payment' => ['payment_id' => $payment->id]])
                                    ->first() ?? false;
                                    //si no esta registrado lo guardo
                                    if($data === false){
                                        $params = (object) array(
                                            'collection_id'       => $payment->id,
                                            'collection_status'   => $payment->status,
                                            'payment_id'          => $payment->id,
                                            'status'              => $payment->status,
                                            'merchant_order_id'   => $element->id,
                                            'preference_id'       => $element->preference_id,
                                            'site_id'             => $element->site_id
                                        );
                                        //guardo en el log
                                        $savelog = Helper::logPaymentSaveStatus($id, $params);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            //return \Response::json(array('status' => ['404',$e->getMessage()]));
            return false;
        }
    }

    // UFT-8 to ANSI
    public static function utf8toansi($content = '')
    {
        return iconv( mb_detect_encoding( $content ), 'Windows-1252', $content );
    }

    // layout update page config for all pages
    public static function updatePageConfig($pageConfigs)
    {
        if (isset($pageConfigs)) {
            if (count($pageConfigs) > 0) {
                foreach ($pageConfigs as $config => $val) {
                    $arr_merge = array_merge(Config::get('layout.' . $config), $val);
                    Config::set('layout.' . $config, $arr_merge);
                }
            }
        }
    }

    // Input validate
    public static function inputValidate($valor, $tipo, $mn, $mx, $required)
    {
        $resp = false;
        switch ($tipo) {
            case "password":
                $permitidos = '/^[a-zA-Z0-9@*_.-]{' . $mn . ',' . ($mx > 0 ? $mx : '') . '}$/i';
                if (strlen($valor) > 0) {
                    if (preg_match($permitidos, $valor))
                        $resp = true;
                    else
                        $resp = false;
                } else if (strlen($valor) == 0 && !$required) {
                    $resp = true;
                } else {
                    $resp = false;
                }
                break;
        }
        return $resp;
    }

    // Usuarios
    public static function usuarioHistory($usuario, $type)
    {
        try {
            $history = new Models\UsuarioHistory();
            $history->usuario_id = $usuario;
            $history->type = $type;
            $history->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // Image
    public static function imageUpload($dir, $file)
    {
        try {
            if (!empty($file)) {
                // Get filename with extension
                $filenameWithExt = $file->getClientOriginalName();
                // Get file path
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Remove unwanted characters
                $filename = preg_replace("/[^A-Za-z0-9 ]/", '', $filename);
                $filename = preg_replace("/\s+/", '-', $filename);
                // Get the original image extension
                $extension = $file->getClientOriginalExtension();
                // Create unique file name
                //$fileNameToStore = $filename.'_'.date('YmdHis').'.'.$extension;
                $fileNameToStore = uniqid() . '_' . date('YmdHis') . '.' . $extension;
                // Resize image
                $resize = FileImage::make($file)->resize(null, 1080, function ($constraint) {
                    $constraint->aspectRatio();
                })->encode('jpg');
                // Create hash value
                $hash = md5($resize->__toString());
                // Prepare qualified image name
                $image = $hash . "jpg";
                // Put image to storage
                $save = Storage::put($dir . $fileNameToStore, $resize->__toString());
                if ($save) {
                    return $fileNameToStore;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    // Image
    public static function imageUploadBase64($dir, $file)
    {
        try {
            if (!empty($file)) {
                $image = $file;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace('data:image/jpg;base64,', '', $image);
                $image = str_replace('data:image/jpeg;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $fileNameToStore = Helper::funcRandId(24) . '.' . 'jpeg';
                // Put image to storage
                $save = Storage::put($dir . $fileNameToStore, base64_decode($image));
                if ($save) {
                    return $fileNameToStore;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function imageEncodeBase64($image_path, $attribute = true)
    {
        try {
            if (!empty($image_path)) {
                $image_path = Storage::path($image_path);
                $type = pathinfo($image_path, PATHINFO_EXTENSION);
                $data = file_get_contents($image_path);
                return ($attribute ? 'data:image/'.$type.';base64,':'').base64_encode($data);
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public static function imageDelete($dir, $file)
    {
        if (!empty($file)) {
            $delete = Storage::delete($dir . $file);
            return $delete;
        } else {
            return false;
        }
    }

    public static function formatDate($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
    }

    public static function formatDateDatabase($date)
    {
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public static function funcRandId($limit)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

    public static function responseInspectionCar($id)
    {
        $data = Models\InspectionCar::where('id', $id)->first() ?? false;
        $response = array();
        if ($data) {
            //fotos
            $fotos = array();
            if($data->images()->count()){
                foreach( $data->images()->get() as $node ){
                    array_push ( $fotos, [
                        'imagen' => '/'.$node->image,
                        'tipo'   => $node->type()->get()[0]->name
                    ]);
                }
            }
            //gnc
            $gnc = array();
            if($data->gnc()->count()){
                foreach( $data->gnc()->get() as $node ){
                    array_push ( $gnc, [
                        'imagen' => '/'.$node->image,
                        'tipo'   => $node->type()->get()[0]->name
                    ]);
                }
            }
            $response['perfil']        = $data->profile;
            $response['anio']          = $data->year;
            $response['danios']        = $data->damages()->pluck('_id');
            $response['email']         = $data->email;
            $response['estado']        = $data->status;
            $response['fecha']         = Carbon::createFromFormat('Y-m-d H:i:s', $data->date);
            $response['fechaServer']   = $data->created_at;
            $response['fotos']         = $fotos;
            $response['gnc']           = $gnc;
            $response['hora']          = Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->toTimeString();
            $response['motivo']        = $data->reason;
            $response['nombre']        = $data->name;
            $response['patente']       = $data->patent;
            $response['telefono']      = $data->phone;
            $response['tipoAutomovil'] = $data->cartype()->get()[0]->name;
            $response['__v']           = $data->__v;
            $response['_id']           = $data->_id;
            return $response;
        } else {
            return false;
        }
    }

    public static function responseInspectionBoat($id)
    {
        $data = Models\InspectionBoat::where('id', $id)->first() ?? false;
        $response = array();
        if ($data) {
            //fotos
            $fotos = array();
            if($data->images()->count()){
                foreach( $data->images()->get() as $node ){
                    array_push ( $fotos, [
                        'imagen' => '/'.$node->image,
                        'tipo'   => $node->type()->get()[0]->name
                    ]);
                }
            }
            //auxiliares
            $auxiliaries = array();
            if($data->auxiliaries()->count()){
                foreach( $data->auxiliaries()->get() as $node ){
                    array_push ( $auxiliaries, [
                        'imagen' => '/'.$node->image,
                        'tipo'   => $node->type()->get()[0]->name
                    ]);
                }
            }
            //documentos
            $documents = array();
            if($data->documents()->count()){
                foreach( $data->documents()->get() as $node ){
                    array_push ( $documents, [
                        'imagen' => '/'.$node->image,
                        'tipo'   => $node->type()->get()[0]->name
                    ]);
                }
            }
            //Daños
            $danios = Models\InspectionBoatDamage::where('inspection_boat_id', $data->id)->first() ?? false;
            $damages = [];
            if($danios){
                $damages['motor']                    = $danios->engine_run;
                $damages['motorAuxiliar']            = $danios->engine_auxiliary;
                $damages['presentaDanioEstructural'] = $danios->damage_structural;
                $damages['presentaDanioVelas']       = $danios->damage_sail;
            }
            $response['perfil']        = $data->profile;
            $response['danios']        = ($danios ? $damages : $data->damages()->get());
            $response['estado']        = $data->status;
            $response['motivo']        = $data->reason;
            $response['elementos']     = $data->elements()->get()->pluck('name');
            $response['instrumentos']  = $data->instruments()->get()->pluck('name');
            $response['_id']           = $data->_id;
            $response['fecha']         = Carbon::createFromFormat('Y-m-d H:i:s', $data->date);
            $response['hora']          = Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->toTimeString();
            $response['nombre']        = $data->name;
            $response['telefono']      = $data->phone;
            $response['email']         = $data->email;
            $response['anio']              = $data->boat_year;
            $response['reyjurisdiccion']   = $data->rey;
            $response['modelo']            = $data->boat_model;
            $response['nombreEmbarcacion'] = $data->boat_name;
            $response['motorCapacidad']    = $data->engine_capacity;
            $response['motorAnio']         = $data->engine_year;
            $response['moneda']            = $data->boat_value_money;
            $response['sumaValuada']       = $data->boat_value;
            $response['tipoEmbarcacion']   = $data->boattype()->get()[0]->name;
            $response['astillero']         = $data->shipyard;
            $response['motorModelo']       = $data->engine_model;
            $response['fotos']             = $fotos;
            $response['auxiliar']          = $auxiliaries;
            $response['documentacion']     = $documents;
            $response['__v']               = $data->__v;

            return $response;
        } else {
            return false;
        }
    }

    public static function responseSinisterCar($id)
    {
        $data = Models\SinisterCar::where('id', $id)->first() ?? false;
        $response = array();
        if ($data) {
            //fotos
            $fotos = array();
            if($data->images()->count()){
                foreach( $data->images()->get() as $node ){
                    array_push ( $fotos, [
                        'imagen' => '/'.$node->image,
                        'tipo'   => $node->type
                    ]);
                }
            }
            $response['perfil']        = $data->profile;
            $response['anio']          = $data->year;
            $response['danios']        = $data->parts()->pluck('_id');
            $response['email']         = $data->email;
            $response['estado']        = $data->status;
            $response['fecha']         = Carbon::createFromFormat('Y-m-d H:i:s', $data->date);
            $response['fechaServer']   = $data->created_at;
            $response['fotos']         = $fotos;
            $response['hora']          = Carbon::createFromFormat('Y-m-d H:i:s', $data->date)->toTimeString();
            $response['motivo']        = $data->reason;
            $response['nombre']        = $data->name;
            $response['patente']       = $data->patent;
            $response['telefono']      = $data->phone;
            $response['tipoAutomovil'] = $data->cartype()->get()[0]->name;
            $response['__v']           = $data->__v;
            $response['_id']           = $data->_id;
            return $response;
        } else {
            return false;
        }
    }


}
