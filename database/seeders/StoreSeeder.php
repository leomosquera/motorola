<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models;
use App\Models\Store;
use Storage;
use App;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Store::truncate(); // Evita duplicar datos

        $json = Storage::get('base/migration/motocare_codigo_tiendas.json');
        $json = json_decode($json, true);
        //dd(count($json));

        foreach ($json as $key => $valor){
            foreach ($valor as $store){
                if (array_key_exists('Código Franquicia', $store)) {
                    $dealer = Models\Dealer::where('code', $key)->first() ?? false;
                    if($dealer){
                        $data = new Models\Store();
                        $data->status = 1;
                        $data->dealer_id = $dealer->id;
                        $data->name = $store['Nombre del PDV'];
                        $data->uniqueid = Str::uuid()->toString();
                        $data->code = $store['Código Franquicia'];
                        $data->address = $store['DESCRIPCIÓN'];
                        $data->location = $store['Ubicación dentro del shopping'];
                        $data->contact = null;
                        $data->email = null;
                        $data->phone = null;
                        $data->save();
                    }
                }
            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
