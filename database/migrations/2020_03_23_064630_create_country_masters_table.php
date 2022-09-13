<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountryMastersTable extends Migration
{
    public function up()
    {
        Schema::create('country_masters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('language', 20);
            $table->string('direction', 5);
            $table->string('abbreviation', 5);
            $table->string('time_zone');
            $table->string('duration')->comment('In Days');
            $table->boolean('status')
                ->default(1)
                ->comment("0 - Inactive / 1 - Active");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_masters');
    }
}
