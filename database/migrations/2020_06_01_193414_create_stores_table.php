<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(0);
            $table->unsignedBigInteger('dealer_id'); // Relación con dealer
            $table->foreign('dealer_id')->references('id')->on('dealers');
            $table->string('name',100);
            $table->string('uniqueid',100);
            $table->string('code',100);
            $table->string('contact',100)->nullable();
            $table->string('address',200)->nullable();
            $table->string('location',200)->nullable();
            $table->string('email',100)->nullable();
            $table->string('phone',50)->nullable();
            $table->string('image',100)->nullable();
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
        Schema::dropIfExists('stores');
    }
}
