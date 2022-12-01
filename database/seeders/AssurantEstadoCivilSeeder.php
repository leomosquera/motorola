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
            ['cod' => '01', 'desc' => 'Casado/a'],
            ['cod' => '02', 'desc' => 'Divorciado/a'],
            ['cod' => '03', 'desc' => 'Soltero/a'],
            ['cod' => '04', 'desc' => 'Viudo/a'],
            ['cod' => '00', 'desc' => 'Otros']
        ];

        foreach ($estado_civil as $valor){
            $data = new EstadoCivil();
            $data->cod  = $valor['cod'];
            $data->desc = $valor['desc'];
            $data->save();
        }
    }
}