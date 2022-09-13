<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CountryFarmer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('country_farmer', function (Blueprint $table) {
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('farmer_id')->unsigned();
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->foreign('country_id')->references('id')->on('country_masters');
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
        //
    }
}
