<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models;
use App\Models\Product;
use Storage;
use App;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints(); //Anulo Foreign Key para el truncate

        Product::truncate(); // Evita duplicar datos

        $json = Storage::get('base/migration/motocare_product.json');
        $json = json_decode($json, true);

        foreach ($json as $valor){
            if (array_key_exists('Product SKU', $valor)) {

                $data   = Models\Product::where('sku', $valor['Product SKU'])->first() ?? false;
                $family = Models\ProductFamily::where('name', $valor['Product Family'])->first() ?? false;
                if(!$data){
                    $data = new Models\Product();
                    $data->product_type_id = 1;
                    $data->product_family_id = $family->id;
                    $data->status = 1;
                    $data->sku = $valor['Product SKU'];
                    $data->elita = $valor['PRODUCT CODE ELITA'];
                    $data->name = $valor['Product Name'];
                    $data->description = $valor['Product Description'];
                    $data->save();
                }

                $data_price = new Models\ProductPrice();
                $data_price->product_id = $data->id;
                $data_price->coverage = $valor['Cobertura'];
                $data_price->duration = $valor['Duracion'];
                $data_price->idnewsanmotocare = $valor['ID Newsan Motocare'];
                $data_price->price_gross = (float)$valor['PRECIO BRUTO EQUIPO'];
                $data_price->price_insured = (float)$valor['Precio Seguro Actualizado'];
                $data_price->price_deductible = (float)$valor['DEDUCIBLE'];
                $data_price->save();

            }
        }

        Schema::enableForeignKeyConstraints();//Habilito Foreign Key
    }
}
