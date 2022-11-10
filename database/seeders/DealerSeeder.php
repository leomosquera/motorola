<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Dealer;
use App\Models;
use App;

class DealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Dealer::truncate(); // Evita duplicar datos

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'Group Mobile';
        $data->code    = 'MO07';
        $data->contact = '';
        $data->email   = 'group.mobile@motorola.com.ar';
        $data->phone   = '11123456789';
        $data->image   = '';
        $data->save();

        for($i=1; $i<=14; $i++){
            $store = new Models\Store();
            $store->dealer_id = $data->id;
            $store->status    = 1;
            $store->name      = $data->name.' '.$i;
            $store->code      = $data->code.$i;
            $store->contact   = '';
            $store->email     = substr($data->email, 0, strpos($data->email, '@')).'.'.$i.'@motorola.com.ar';
            $store->phone     = $data->phone.$i;
            $store->image     = '';
            $store->save();
        }

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'ICH';
        $data->code    = 'MO08';
        $data->contact = '';
        $data->email   = 'ich@motorola.com.ar';
        $data->phone   = '11123456789';
        $data->image   = '';
        $data->save();

        for($i=1; $i<=3; $i++){
            $store = new Models\Store();
            $store->dealer_id = $data->id;
            $store->status    = 1;
            $store->name      = $data->name.' '.$i;
            $store->code      = $data->code.$i;
            $store->contact   = '';
            $store->email     = substr($data->email, 0, strpos($data->email, '@')).'.'.$i.'@motorola.com.ar';
            $store->phone     = $data->phone.$i;
            $store->image     = '';
            $store->save();
        }

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'Grupo Móvil / del Litoral';
        $data->code    = 'MO09';
        $data->contact = '';
        $data->email   = 'grupo.movil.del.litoral@motorola.com.ar';
        $data->phone   = '11123456789';
        $data->image   = '';
        $data->save();

        for($i=1; $i<=3; $i++){
            $store = new Models\Store();
            $store->dealer_id = $data->id;
            $store->status    = 1;
            $store->name      = $data->name.' '.$i;
            $store->code      = $data->code.$i;
            $store->contact   = '';
            $store->email     = substr($data->email, 0, strpos($data->email, '@')).'.'.$i.'@motorola.com.ar';
            $store->phone     = $data->phone.$i;
            $store->image     = '';
            $store->save();
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
