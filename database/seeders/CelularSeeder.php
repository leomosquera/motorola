<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Celular;
use Storage;
use App;

class CelularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Celular::truncate(); // Evita duplicar datos

        $json = Storage::get('base/migration/celulares.json');
        $json = json_decode($json, true);

        foreach ($json as $valor){
            if (array_key_exists('PRODUCT CODE ELITA', $valor)) {

                $data = Celular::where('elita', $valor['PRODUCT CODE ELITA'])->first() ?? false;
                //if(!$data){
                    $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $data = new Celular();
                    $data->status = 1;
                    $data->code = substr(str_shuffle($permitted_chars), 0, 4).uniqid();
                    $data->name = trim($valor['Product Name (listado de equipos)']);
                    $data->gama = trim($valor['GAMAS']); 
                    $data->cobertura = trim($valor['Cobertura']);
                    $data->elita = trim($valor['PRODUCT CODE ELITA']);
                    $data->precio_bruto_equipo = floatval($valor['PRECIO BRUTO EQUIPO']);
                    $data->precio_seguro = floatval($valor['Precio Seguro Actualizado']);
                    $data->version = trim($valor['Product Description']);
                    $data->save();
                //}

            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
