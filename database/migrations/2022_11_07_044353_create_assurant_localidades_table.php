<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssurantLocalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assurant_localidades', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('provincia_cod',1); // Relación con usuario
            $table->foreign('provincia_cod')->references('cod')->on('assurant_provincias');
            $table->string('cod', 20)->unique();
            $table->string('nombre', 50);
            $table->string('cp', 20)->nullable();
            $table->string('preftel', 50)->nullable();
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
        Schema::dropIfExists('assurant_localidades');
    }
}
