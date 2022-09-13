<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->tinyInteger('item_type')->comment("1-news/2-marketing/3-bids/4-selling_request/5-account activation / 6 - account rejection");
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')
            ->references('id')
            ->on('country_masters');
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('type')->comment("1-web notification / 2 - push notification");
            $table->tinyInteger('device_type')->comment("1-web / 2 - android / 3- ios");
            $table->string('ip_address')->nullable();
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
