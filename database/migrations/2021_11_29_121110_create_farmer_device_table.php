<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmerDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmer_device', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('farmer_id')->unsigned();
            $table->foreign('farmer_id')->references('id')->on('farmers');
            $table->text('fcm_token');
            $table->text('device_token');
            $table->tinyInteger('device_type')->comment('1-> Android, 2-> IOS');
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
        Schema::dropIfExists('farmer_device');
    }
}
