<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\CertificadoHTML;
use Illuminate\Support\Facades\Mail;
use App\Models;
use Helper;

use Illuminate\Support\Facades\Bus;
use App\Jobs\SendCampaignCertificateMail;

class CampaignLogController extends ApiController
{
    private static function sendmail(){
        return config('enviroment.sendmail');
    }

    public function store(Request $request){
        try{
            //campaña pertenece al usuario?
            $data = Models\Campaign::where('id', $request->campaign_id)->where('usuario_id', auth('api')->user()->id)->first() ?? false;
            //store / tienda
            $store = Models\Store::where('uniqueid', $request->store)->first() ?? false;
            $store = $store ? $store->id : null;
            //body to array
            $body = !empty($request->body) ? json_decode($request->body) : [];

            //recordar que ahora guarda sin importar si existe el store if($data && $store)
            //en el caso que si o si sea con store siempre if($data && $store)
            if($data){
                //valido request
                $validator = Validator::make($request->all(), [
                    'store'               => $store === null ? '' : 'required|max:100',
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
                    $campaignlog->store_id            = $store;
                    $campaignlog->campaign_info       = $request->campaign_info;
                    $campaignlog->id_log              = $request->id_log;
                    $campaignlog->payment_code        = strpos($request->event, 'payment') !== false ? 'MP' : ( !empty($body->medio) ? $body->medio : null);
                    $campaignlog->url_referer_encrypt = $request->url_referer_encrypt;
                    $campaignlog->url_referer_decrypt = $request->url_referer_decrypt;
                    $campaignlog->body                = $request->body;
                    $campaignlog->services            = $request->services;
                    $campaignlog->params              = json_encode($request->params);
                    $campaignlog->event               = $request->event;
                    $campaignlog->ip_info             = $request->ip_info;
                    $campaignlog->save();

                    //evento que determina que llego al final e ingreso medio de pago
                    if($request->event == 'medio de pago'){
						//busco datos del producto
						$services = json_decode($request->services);
						foreach ($services->products->data as $product){
							//el producto que coincide con el guardado en params es el elegido
							if($request->params['codarticulo']['value'] == $product->code){

                                //tipo de envio de mail, local o por sendermail
                                switch (self::sendmail()['type']) {
                                    case 'local':

                                        // Datos dinámicos
                                        $data = [
                                            'nombre'           => substr(preg_replace('/\s+/', ' ', $request->params['nombres']['value']), 0, 50),
                                            'detalleCobertura' => $product->cobertura,
                                            'costoMensual'     => number_format($product->precio_seguro, 2, ',', '.').' por mes',
                                        ];
                                        
                                        // 1) Generar PDF desde Blade
                                        $pdf = Pdf::loadView('emails.certificado.html', $data)->setPaper('A4', 'portrait');
                                        // Si usás URLs externas en imágenes:
                                        // $pdf->setOption(['isRemoteEnabled' => true]);

                                        $pdfContent = $pdf->output();

                                        // 2) Guardar en storage/app/certificados/
                                        $filename = 'Solicitud-de-compra-'.date('YmdHis').'.pdf';
                                        $path = 'certificados/'.$filename; // relativo a storage/app
                                        Storage::put($path, $pdfContent);

                                        // 3) Enviar mail con HTML + adjuntar PDF
                                        $subject = '¡Gracias! Hemos recibido tu solicitud de compra';
                                        $from = '';
                                        $from_name = 'Protección Motocare';
                                        $bcc  = '';

                                        $from = self::sendmail()['local']['from'];
                                        $bcc  = self::sendmail()['local']['bcc'];
                                        Mail::to($request->params['email']['value'])
                                            ->bcc($bcc)
                                            ->send(new CertificadoHTML(
                                            [
                                                'nombre'           => $data['nombre'],
                                                'detalleCobertura' => $data['detalleCobertura'],
                                                'costoMensual'     => $data['costoMensual'],
                                            ],
                                            $pdfContent,
                                            $filename,
                                            $subject,
                                            $from,
                                            $from_name
                                        ));

                                        // ✅ Guardar flag de envío correcto
                                        $campaignlog->send_mail = 1;
                                        $campaignlog->save();
                                        break;

                                    case 'mailersend':

                                        Bus::dispatchSync(new SendCampaignCertificateMail($campaignlog->id));
                                        break;
                                }

								return response()->json(['ok' => true, 'path' => $path]);
							}
						}

                    }

                    return $this->successResponse($validator->fails(),'Log guardado.', 201);
                }else{
                    return $this->errorResponse($validator->errors(), 404);
                }
            }else{
                return $this->errorResponse('La campaña no fue encontrada o no pertenece a este usuario.', 404);
            }
        }
        catch(\Exception $e){
            //return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
            return $this->errorResponse($e, 404);
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
            $data  = Models\CampaignLog::
            where('id_log', $request->id_log)
            ->where('event', 'payment_init')
            ->withCount('file_register')
            ->latest()
            ->first() ?? false;
            if($data && $data->file_register_count == 0){
                $savelog = Helper::mpPaymentUpdateAllStatus($data->id, $request->params['preference_id']);
                if($savelog !== false){
                    return $this->successResponse($savelog,'Log guardado.', 201);
                }else{
                    return $this->errorResponse('El pago para esta operación ya fue procesado o se produjo un error al procesarlo.', 404);
                }
            }else{
                return $this->errorResponse('El pago para esta operación ya fue procesado o se produjo un error al procesarlo.', 404);
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

    public function validateImei($imei = null, Request $request){
        try{
            $resp = false;
            //primero busco un imei con un pago iniciado
            $data = Models\CampaignLog::whereJsonContains('params', ['imei' => ['value' => $request->imei]])
            ->where('event','payment_init')
            ->withCount('payment_approved')
            ->has('payment_approved','>',0);

            if($data->count()>0){
                $resp = true;
            }else{
                $data = Models\CampaignLog::whereJsonContains('params', ['imei' => ['value' => $request->imei]])
                ->where('event','payment_init');
                //reviso todos los pagos iniciados con el imei y veo si alguno fue aprobado
                if($data->count()>0){
                    foreach ($data->get() as $log){
                        if($log->payment_approved_count==0){
                            $body = json_decode($log->body);
                            if(strlen($body->ref)>0){
                                if(Helper::mpPaymentApproved($body->ref)){
                                    $resp = true;
                                    break;
                                }
                            }
                        }
                    }
                }
            }

            return $this->successResponse($resp, 'Validación imei procesado con pago aprobado.', 302);
        }
        catch(\Exception $e){
           return $this->errorResponse('Error de sistema. Algunos de los parámateros enviados no existen o no poseen el formato correcto.', 404);
           //return $this->errorResponse($e->getMessage(), 404);
        }
    }
}
