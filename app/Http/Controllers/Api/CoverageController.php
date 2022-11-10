<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Models;

class CoverageController extends ApiController
{
    public function info(Request $request){

        $data = [
            [
                'id'           => 1,
                'code'         => 'RD',
                'title'        => 'Full Protection - Robo + Accidente',
                'duration'     => 12,
                'payment_type' => 'pago único',
                'description'  => '12 meses de cobertura, Pago único del seguro, Cobertura frente a daños accidentales, Cobertura frente a robos'
            ],
            [
                'id'           => 2,
                'code'         => 'RD',
                'title'        => 'Full Protection - Robo + Accidente',
                'duration'     => 24,
                'payment_type' => 'pago único',
                'description'  => '24 meses de cobertura, Pago único del seguro, Cobertura frente a daños accidentales, Cobertura frente a robos'
            ],
            [
                'id'           => 3,
                'code'         => 'AD',
                'title'        => 'Accident Protection - Accidente',
                'duration'     => 12,
                'payment_type' => 'pago único',
                'description'  => '12 meses de cobertura, Pago único del seguro, Cobertura frente a daños accidentales, Cobertura frente a robos'
            ],
            [
                'id'           => 4,
                'code'         => 'AD',
                'title'        => 'Accident Protection - Accidente',
                'duration'     => 24,
                'payment_type' => 'pago único',
                'description'  => '24 meses de cobertura, Pago único del seguro, Cobertura frente a daños accidentales, Cobertura frente a robos'
            ],
        ];

        return $this->successResponse($data,'Lista de Coberturas', 302);

    }
}
