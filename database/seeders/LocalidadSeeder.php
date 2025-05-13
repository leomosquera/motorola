<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Assurant\Provincia;
use App\Models\Assurant\Localidad;
use Storage;

class LocalidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private function generarIdUnico($largo = 6) {
        $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $id = '';
        for ($i = 0; $i < $largo; $i++) {
            $id .= $caracteres[random_int(0, strlen($caracteres) - 1)];
        }
        return $id;
    }
    
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Localidad::truncate(); // Evita duplicar datos

        //Estlio 1
        /*
        $json = Storage::get('base/migration/Codigos-Postales-Argentina_provincias_corregidas_codigos.json');
        $json = json_decode($json, true);

        foreach ($json as $valor){

            $localidad = Localidad::
                where('nombre', $valor['Localidad'])
                ->where('provincia_cod', $valor['code'])
                ->first() ?? false;
        
            $data = new Localidad();
            $data->status        = !$localidad ? 1 : 0;
            $data->provincia_cod = $valor['code'];
            $data->cod           = $valor['branch_code'].'-'.$this->generarIdUnico();
            $data->nombre        = $valor['Localidad'];
            $data->cp            = $valor['CP'];
            $data->save();
        }
        */

        //Estlio 2
        $jsonLoc = Storage::get('base/migration/localidad.json');
        $jsonLoc = json_decode($jsonLoc, true);

        foreach ($jsonLoc as $valor){

            $provincia = Provincia::
                where('status', 1)
                ->where('id', $valor['provincia_id'])
                ->first() ?? false;

            $localidad = Localidad::
                where('nombre', $valor['nombre'])
                ->where('provincia_cod', $provincia['cod'])
                ->first() ?? false;

        
            $data = new Localidad();
            $data->status        = !$localidad && $valor['nombre'] != 'C.A.B.A.' ? 1 : 0;
            $data->provincia_cod = $provincia['cod'];
            $data->cod           = $provincia['branch_code'].'-'.$this->generarIdUnico();
            $data->nombre        = ucfirst(strtolower($valor['nombre']));
            $data->cp            = $valor['codigopostal'];
            $data->save();

            if($provincia['cod'] == "C"){
                $json = Storage::get('base/migration/Codigos-Postales-Argentina_provincias_corregidas_codigos.json');
                $json = json_decode($json, true);
                foreach ($json as $valor){
                    if($valor['code'] == "C"){
                        $localidad = Localidad::
                        where('nombre', $valor['Localidad'])
                        ->where('provincia_cod', $valor['code'])
                        ->first() ?? false;
                
                        $data = new Localidad();
                        $data->status        = !$localidad ? 1 : 0;
                        $data->provincia_cod = $valor['code'];
                        $data->cod           = $valor['branch_code'].'-'.$this->generarIdUnico();
                        $data->nombre        = $valor['Localidad'];
                        $data->cp            = $valor['CP'];
                        $data->save();
                    }
                }
            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
