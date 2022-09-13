<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VarietyMaster extends Migration
{
    public function up()
    {
        Schema::create('varieties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('commodity_id');

            $table->boolean('status')
                ->default(1)
                ->comment("0 - Inactive / 1 - Active");

            $table->foreign('commodity_id')
                ->references('id')
                ->on('commodity_masters');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('varieties');
    }
}
