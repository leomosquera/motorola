<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_price', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id', 'fk_priceproduct_price')->references('id')->on('products')->onDelete('cascade');
            $table->string('coverage',20)->nullable();
            $table->Integer('duration')->default(0);
            $table->string('idnewsanmotocare',50)->nullable();
            $table->decimal('price_gross',9,2)->default(0.00);
            $table->decimal('price_insured',9,2)->default(0.00);
            $table->decimal('price_deductible',9,2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_price');
    }
}
