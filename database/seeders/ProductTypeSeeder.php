<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        ProductType::truncate(); // Evita duplicar datos

        $data = new ProductType();
        $data->name = 'celulares';
        $data->save();

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
