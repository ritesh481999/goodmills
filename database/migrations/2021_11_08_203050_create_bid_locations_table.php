<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('bid_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bid_id');
            $table->unsignedBigInteger('bid_location_id');
            $table->foreign('bid_id')
                ->references('id')
                ->on('bids');
            $table->foreign('bid_location_id')
                ->references('id')
                ->on('bid_location_masters');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bid_locations');
    }
}
