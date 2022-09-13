<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellingRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('selling_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bid_id')->nullable();
            $table->date('date_of_movement');
            $table->unsignedBigInteger('commodity_id');
            $table->unsignedBigInteger('specification_id');
            $table->unsignedBigInteger('variety_id');
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedInteger('tonnage');

            $table->unsignedBigInteger('delivery_location_id')
                ->nullable()
                ->comment('when You Deliver is selected as delivery method');

            $table->tinyInteger('delivery_method')
                ->comment('1 - X-Farm / 2 - You Deliver');

            $table->string('delivery_address', 255)->nullable();
            $table->string('postal_code', 10)->nullable();

            $table->foreign('farmer_id')
                ->references('id')
                ->on('farmers');

            $table->foreign('commodity_id')
                ->references('id')
                ->on('commodity_masters');

            $table->foreign('specification_id')
                ->references('id')
                ->on('specification_masters');;

            $table->foreign('variety_id')
                ->references('id')
                ->on('varieties');

            $table->foreign('delivery_location_id')
                ->references('id')
                ->on('delivery_locations');
            $table->foreign('country_id')
                ->references('id')
                ->on('country_masters');

            $table->string('reason', 255)->nullable();

            $table->tinyInteger('status')
                ->comment('1 - Request Recieved / 2 - Bid Sent / 3 - Request Rejected By Admin / 4 - Bid Accepted By Farmer / 5 - Bid Rejected By Farmer')
                ->default(1);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('selling_requests');
    }
}
