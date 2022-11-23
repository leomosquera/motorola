<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coverage;

class CoverageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //servicio assurant
        $coverage = [
            [
                'id'           => 1,
                'code'         => 'RD',
                'title'        => 'Seguro de Robo + Accidente',
                'duration'     => 12,
                'payment_type' => 'pago único',
                'description'  => 'ok**12 meses de cobertura|ok**Cobertura frente a daños accidentales|ok**Cobertura frente a robos'
            ],
            [
                'id'           => 2,
                'code'         => 'RD',
                'title'        => 'Seguro de Robo + Accidente',
                'duration'     => 24,
                'payment_type' => 'pago único',
                'description'  => 'ok**24 meses de cobertura|ok**Cobertura frente a daños accidentales|ok**Cobertura frente a robos'
            ],
            [
                'id'           => 3,
                'code'         => 'AD',
                'title'        => 'Seguro de Accidente',
                'duration'     => 12,
                'payment_type' => 'pago único',
                'description'  => 'ok**12 meses de cobertura|ok**Cobertura frente a daños accidentales|no**Cobertura frente a robos'
            ],
            [
                'id'           => 4,
                'code'         => 'AD',
                'title'        => 'Seguro de Accidente',
                'duration'     => 24,
                'payment_type' => 'pago único',
                'description'  => 'ok**24 meses de cobertura|ok**Cobertura frente a daños accidentales|no**Cobertura frente a robos'
            ]
        ];

        foreach ($coverage as $valor){
            $data = new Coverage();
            $data->status       = 1;
            $data->code         = $valor['code'];
            $data->title        = $valor['title'];
            $data->duration     = $valor['duration'];
            $data->payment_type = $valor['payment_type'];
            $data->description  = $valor['description'];
            $data->save();
        }
    }
}
