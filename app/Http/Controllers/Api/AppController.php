<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Config;

class AppController extends ApiController
{
    public function version(){

        $response = [
			'message' => 'ok',
			'version' => 'v.1.0.0'
        ];

        return response()->json($response, ($response['message']=='ok'?200:404));
    }

}
