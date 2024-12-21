<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssurantProvinciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assurant_provincias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod', 1)->unique();
            $table->string('branch_code', 2)->unique();
            $table->string('nombre', 50)->unique();
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
        Schema::dropIfExists('assurant_provincias');
    }
}
