<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campaign_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('usuario_id'); // Relación con usuario
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unsignedBigInteger('campaign_id'); // Relación con campaña
            $table->foreign('campaign_id')->references('id')->on('campaigns');
            $table->unsignedBigInteger('store_id')->nullable(); // Relación con stores / tiendas
            $table->foreign('store_id')->references('id')->on('stores');
            $table->json('campaign_info')->nullable();
            $table->string('id_log',100);
            $table->string('payment_code',10)->nullable();
            $table->boolean('payment_verified')->default(0);
            $table->string('url_referer_encrypt',1000)->nullable();
            $table->string('url_referer_decrypt',1000)->nullable();
            $table->json('body')->nullable();
            $table->json('services')->nullable();
            $table->json('params')->nullable();
            $table->string('event',30)->nullable();
            $table->string('ip_info',100)->nullable();
            $table->string('file',100)->nullable();
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
        Schema::dropIfExists('campaign_logs');
    }
}
