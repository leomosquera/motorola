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

        foreach ($json as $valor){
            if (array_key_exists('Código Tienda', $valor)) {

                $dealer = Models\Dealer::where('code', $valor['Código Franquicia'])->first() ?? false;
                if($dealer){
                    $data = new Models\Store();
                    $data->status = 1;
                    $data->dealer_id = $dealer->id;
                    $data->name = $valor['DESCRIPCIÓN'];
                    $data->uniqueid = Str::uuid()->toString();
                    $data->code = $valor['Branch Code'];
                    $data->contact = null;
                    $data->email = null;
                    $data->phone = null;
                    $data->save();
                }

            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
