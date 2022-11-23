<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\ProductFamily;
use Storage;
use App;

class ProductFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        ProductFamily::truncate(); // Evita duplicar datos

        $json = Storage::get('base/migration/motocare_product.json');
        $json = json_decode($json, true);

        foreach ($json as $valor){
            if (array_key_exists('Product Family', $valor)) {
                if(!ProductFamily::where('name', $valor['Product Family'])->first() ?? false){
                    $data = new ProductFamily();
                    $data->name = $valor['Product Family'];
                    $data->save();
                }
            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
