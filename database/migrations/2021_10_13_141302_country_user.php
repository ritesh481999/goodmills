<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CountryUser extends Migration
{
    public function up()
    {
        Schema::create('country_user', function (Blueprint $table) {
            $table->bigInteger('country_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('country_user');
    }
}
