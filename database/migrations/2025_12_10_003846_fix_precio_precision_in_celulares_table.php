<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPrecioPrecisionInCelularesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('celulares', function (Blueprint $table) {
            $table->decimal('precio_bruto_equipo', 15, 2)->default(0.00)->change();
            $table->decimal('precio_seguro', 15, 2)->default(0.00)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('celulares', function (Blueprint $table) {
            //
        });
    }
}
