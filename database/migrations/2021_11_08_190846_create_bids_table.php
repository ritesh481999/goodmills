<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidsTable extends Migration
{
    public function up()
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('selling_request_id')->nullable();
            $table->string('bid_code', 50)->unique();

            $table->foreign('selling_request_id')
                ->references('id')
                ->on('selling_requests');

            $table->unsignedBigInteger('commodity_id');
            $table->unsignedBigInteger('specification_id');
            $table->unsignedBigInteger('variety_id');

            $table->unsignedBigInteger('delivery_location_id')
                ->nullable()
                ->comment('when X-Farm is selected as delivery method');

            $table->tinyInteger('delivery_method')
                ->comment('1 - X-Farm / 2 - You Deliver');

            $table->string('delivery_address', 255)->nullable();
            $table->string('postal_code', 10)->nullable();

            $table->foreign('commodity_id')
                ->references('id')
                ->on('commodity_masters');

            $table->foreign('specification_id')
                ->references('id')
                ->on('specification_masters');

            $table->foreign('variety_id')
                ->references('id')
                ->on('varieties');

            $table->foreign('delivery_location_id')
                ->references('id')
                ->on('delivery_locations');

            $table->string('bid_name')->nullable();
            $table->dateTime('publish_on')->nullable();
            $table->date('date_of_movement');
            $table->unsignedInteger('max_tonnage');
            $table->double('price', 15, 2)->nullable();
            //$table->decimal('price', 15, 2);
            $table->timestamp('valid_till')->nullable();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')
            ->references('id')
            ->on('country_masters');
            $table->boolean('status')
                ->default(1)
                ->comment("0 - Inactive, 1 - Active , 2 - selling request reject by admin");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bids');
    }
}
