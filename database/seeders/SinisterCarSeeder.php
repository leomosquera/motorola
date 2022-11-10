<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Carbon;
use App\Models;
use Storage;

class SinisterCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate
        Models\SinisterCar::truncate(); // Evita duplicar datos

        $json = Storage::get('base/migration/inspeccionsiniestros.json');
        $json = json_decode($json, true);
        $fecha_aux = '';

        foreach ($json as $valor){
            //Fecha y hora
            if(gettype($valor['fecha'])=='string'){
                $fecha = explode('/',$valor['fecha']);
                $hora  = explode(':',$valor['hora']);
                if( count($fecha)>=2 && count($hora)>=2 ){
                    $fecha = $fecha[0].'/'.$fecha[1].'/'.$fecha[2].' '.(strlen($hora[0])==1?'0'.$hora[0]:$hora[0]).':'.(strlen($hora[1])==1?'0'.$hora[1]:$hora[1]).':00';
                    $fecha_aux = $fecha;
                }else{
                    $fecha = $fecha_aux;
                }
            }else{
                $fecha = explode('-',substr($valor['fecha']['$date'],0,10));
                $hora  = explode(':',$valor['hora']);
                if( count($fecha)>=2 && count($hora)>=2 ){
                    if(count($hora)==3){
                        $fecha = $fecha[2].'/'.$fecha[1].'/'.$fecha[0].' '.(strlen($hora[0])==1?'0'.$hora[0]:$hora[0]).':'.(strlen($hora[1])==1?'0'.$hora[1]:$hora[1]).':'.(strlen($hora[2])==1?'0'.$hora[2]:$hora[2]);
                    }else{
                        $fecha = $fecha[2].'/'.$fecha[1].'/'.$fecha[0].' '.(strlen($hora[0])==1?'0'.$hora[0]:$hora[0]).':'.(strlen($hora[1])==1?'0'.$hora[1]:$hora[1]).':00';
                    }
                    $fecha_aux = $fecha;
                }else{
                    $fecha = $fecha_aux;
                }
            }

            //Tipo
            if (array_key_exists('tipoAutomovil', $valor)) {
                $siniscartype = Models\CarType::where('name', $valor['tipoAutomovil'])->first() ?? false;
                if($siniscartype){
                    $car_type_id = $siniscartype->id;
                }else{
                    $car_type_id = 1;
                }
            }else{
                $car_type_id = 1;
            }

            $siniscar = new Models\SinisterCar();
            $siniscar->_id = $valor['_id']['$oid'];
            $siniscar->usuario_id  = 1;
            $siniscar->car_type_id = $car_type_id;
            $siniscar->status = $valor['estado'];
            $siniscar->reason = $valor['motivo'];
            $siniscar->date = Carbon::createFromFormat('d/m/Y H:i:s', $fecha)->format('Y-m-d H:i:s');
            $siniscar->name = $valor['nombre'];
            $siniscar->phone = $valor['telefono'];
            $siniscar->email = $valor['email'];
            $siniscar->patent = $valor['patente'];
            $siniscar->year = $valor['anio'];
            $siniscar->save();
            //partes
            if(count($valor['danios'])>0){
                foreach ($valor['danios'] as $valor2){
                    $part = Models\CarPart::where('name', $valor2)->first() ?? false;
                    if($part){
                        $siniscar->parts()->attach([$part->id]);
                    }
                }
            }
            //fotos
            if(count($valor['fotos'])>0){
                foreach ($valor['fotos'] as $valor2){
                    $siniscarimage = new Models\SinisterCarImage();
                    $siniscarimage->sinister_car_id = $siniscar->id;
                    $siniscarimage->type            = $valor2['tipo'];
                    $siniscarimage->image           = str_replace('/', '', $valor2['imagen']);
                    $siniscarimage->save();
                }
            }
        }
    }
}
