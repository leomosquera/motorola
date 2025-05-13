<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Assurant\Provincia;
use Storage;

class ProvinciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Provincia::truncate(); // Evita duplicar datos

        $json = Storage::get('base/migration/provincias.json');
        $json = json_decode($json, true);

        $arr_codigo31662 = [ 
            'B' => 'AR-B',
            'C' => 'AR-C',
            'K' => 'AR-K',
            'H' => 'AR-H',
            'U' => 'AR-U',
            'X' => 'AR-X',
            'W' => 'AR-W',
            'E' => 'AR-E',
            'P' => 'AR-P',
            'Y' => 'AR-Y',
            'L' => 'AR-L',
            'F' => 'AR-F',
            'M' => 'AR-M',
            'N' => 'AR-N',
            'Q' => 'AR-Q',
            'R' => 'AR-R',
            'A' => 'AR-A',
            'J' => 'AR-J',
            'D' => 'AR-D',
            'Z' => 'AR-Z',
            'S' => 'AR-S',
            'G' => 'AR-G',
            'V' => 'AR-V',
            'T' => 'AR-T',
        ];

        foreach ($json as $valor){
            $data = Provincia::where('branch_code', $valor['branch_code'])->first() ?? false;
            if(!$data){
                $data = new Provincia();
                $data->status      = 1;
                $data->cod         = $valor['cod'];
                $data->branch_code = $valor['branch_code'];
                $data->nombre      = $valor['nombre'];
                $data->codigo31662 = $arr_codigo31662[$valor['cod']];
                $data->save();
            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
