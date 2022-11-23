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
        $data->email   = 'group.mobile@motocare.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'ICH';
        $data->code    = 'MO08';
        $data->contact = '';
        $data->email   = 'ich@motocare.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'Grupo Móvil / del Litoral';
        $data->code    = 'MO09';
        $data->contact = '';
        $data->email   = 'grupo.movil.del.litoral@motocare.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
