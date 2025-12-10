<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCampaignFilesTable extends Migration
{
    public function up()
    {
        Schema::create('campaign_files', function (Blueprint $table) {
            $table->id();

            $table->string('txt_name');
            $table->string('zip_name');
            $table->string('txt_path');
            $table->string('zip_path');
            $table->date('day');

            $table->enum('status', [
                'generated',
                'sent',
                'error'
            ])->default('generated');

            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('campaign_files');
    }
}

