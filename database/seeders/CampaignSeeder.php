<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        //Campaign::truncate(); // Evita duplicar datos

        $data = new Campaign();
        $data->usuario_id       = 1;
        $data->status           = 1;
        $data->name             = 'Moto Care';
        $data->date_start       = '2022-11-05';
        $data->date_end         = '2024-11-05';
        $data->url              = 'https://motorola.test';
        $data->privacy_policy   = '';
        $data->terms_conditions = '';
        $data->google_analytics = '';
        $data->save();


        //Campaign::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
