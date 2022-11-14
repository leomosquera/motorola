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
