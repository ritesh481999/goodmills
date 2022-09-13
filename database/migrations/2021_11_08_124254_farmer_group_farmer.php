<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FarmerGroupFarmer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farmer_group_farmers', function (Blueprint $table) {
            $table->bigInteger('farmer_group_id')->unsigned();
            $table->bigInteger('farmer_id')->unsigned();

            $table->foreign('farmer_group_id')->references('id')->on('farmer_groups');
            $table->foreign('farmer_id')->references('id')->on('farmers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('farmer_group_farmers');
    }
}
