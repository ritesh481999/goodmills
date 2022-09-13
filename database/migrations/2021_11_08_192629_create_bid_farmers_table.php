<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBidFarmersTable extends Migration
{
    public function up()
    {
        Schema::create('bid_farmers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bid_id');
            $table->unsignedBigInteger('farmer_id');
            $table->unsignedInteger('tonnage')->nullable();
            $table->string('counter_offer')->nullable();
            $table->string('reason')->nullable();
            ///$table->text('reason')->nullable();

            $table->tinyInteger('status')
                ->default(0)
                ->comment("0 - Pending / 1 - Accepted / 2 - Rejected / 3 - Counter-offer accepted by admin / 4 - Counter-offer rejected by admin");

            $table->foreign('bid_id')
                ->references('id')
                ->on('bids');

            $table->foreign('farmer_id')
                ->references('id')
                ->on('farmers');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bid_farmers');
    }
}
