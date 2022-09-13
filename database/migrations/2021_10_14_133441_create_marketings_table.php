<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarketingsTable extends Migration
{
    public function up()
    {
        Schema::create('marketings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('short_description');
            $table->text('description');
            $table->string('image')->nullable();
            $table->timestamp('publish_on');
            $table->unsignedBigInteger('country_id');

            $table->foreign('country_id')
            ->references('id')
            ->on('country_masters')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->boolean('is_sms')
            ->default(0)
            ->comment("0 - No / 1 - Yes");

            $table->boolean('is_notification')
            ->default(0)
            ->comment("0 - No / 1 - Yes");

            $table->boolean('status')
                ->default(1)
                ->comment("0 - Inactive / 1 - Active");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketings');
    }
}
