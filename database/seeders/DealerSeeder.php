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

        /*
        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'Group Mobile';
        $data->code    = 'MO07';
        $data->contact = '';
        $data->email   = 'group.mobile@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'ICH';
        $data->code    = 'MO08';
        $data->contact = '';
        $data->email   = 'ich@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'Grupo Móvil / del Litoral';
        $data->code    = 'MO09';
        $data->contact = '';
        $data->email   = 'grupo.movil.del.litoral@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();
        */

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'NEWSAN';
        $data->code    = 'NS';
        $data->contact = '';
        $data->email   = 'ns@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'OPEN PHONE';
        $data->code    = 'OP';
        $data->contact = '';
        $data->email   = 'op@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'ICH';
        $data->code    = 'ICH';
        $data->contact = '';
        $data->email   = 'ich@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'GRUPO MOVIL';
        $data->code    = 'GM';
        $data->contact = '';
        $data->email   = 'gm@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        $data = new Dealer();
        $data->status  = 1;
        $data->name    = 'STARCEL';
        $data->code    = 'ST';
        $data->contact = '';
        $data->email   = 'sr@proteccionmobile.com.ar';
        $data->phone   = '1111111111111';
        $data->image   = '';
        $data->save();

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
