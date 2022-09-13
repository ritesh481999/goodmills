<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommodityMastersTable extends Migration
{
    public function up()
    {
        Schema::create('commodity_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');

            $table->boolean('status')
                ->default(1)
                ->comment("0 -Inactive / 1 - Active");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commodity_masters');
    }
}
