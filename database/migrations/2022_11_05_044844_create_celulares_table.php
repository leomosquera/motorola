<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCelularesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('celulares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(0);
            $table->string('code',30);
            $table->string('sku',30);
            $table->string('name',50);
            $table->string('gama',50);
            $table->boolean('discontinuado')->default(0);
            $table->string('cobertura',50);
            $table->string('elita',20)->nullable();
            $table->decimal('precio_bruto_equipo',11,2)->default(0.00);
            $table->decimal('precio_seguro',11,2)->default(0.00);
            $table->string('version',100);
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
        Schema::dropIfExists('celulares');
    }
}
