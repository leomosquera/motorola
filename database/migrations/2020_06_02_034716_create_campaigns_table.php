<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('campaigns', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('usuario_id'); // Relación con usuario
        $table->foreign('usuario_id')->references('id')->on('usuarios');
        $table->boolean('status')->default(0);
        $table->string('name',100)->nullable();
        $table->dateTime('date_start')->nullable();
        $table->dateTime('date_end')->nullable();
        $table->string('url',100)->nullable();
        $table->text('google_analytics')->nullable();
        $table->text('privacy_policy')->nullable();
        $table->text('terms_conditions')->nullable();
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
        Schema::dropIfExists('campaigns');
    }
}
