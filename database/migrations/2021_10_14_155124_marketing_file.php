<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MarketingFile extends Migration
{
    public function up()
    {
        Schema::create('marketing_files', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('marketing_id');
            $table->foreign('marketing_id')
                ->references('id')
                ->on('marketings')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('file_name');
            $table->string('file_mime_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketing_files');
    }
}
