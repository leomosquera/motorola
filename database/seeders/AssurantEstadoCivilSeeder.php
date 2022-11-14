<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assurant\EstadoCivil;

class AssurantEstadoCivilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //servicio assurant
        $estado_civil = [
            ['cod' => 'SOL', 'desc' => 'SOLTERO/A'],
            ['cod' => 'CAS', 'desc' => 'CASADO/A'],
            ['cod' => 'CON', 'desc' => 'CONVIVIENTE'],
            ['cod' => 'SEP', 'desc' => 'SEPARADO/A'],
            ['cod' => 'VIU', 'desc' => 'VIUDO/A']
        ];

        foreach ($estado_civil as $valor){
            $data = new EstadoCivil();
            $data->cod  = $valor['cod'];
            $data->desc = $valor['desc'];
            $data->save();
        }
    }
}