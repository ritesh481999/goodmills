<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile_number', 16)->nullable();
            $table->unsignedBigInteger('selected_country_id');
            $table->foreign('selected_country_id')
                ->references('id')
                ->on('country_masters');
            $table->string('password');
            $table->rememberToken();
            $table->text('fcm_token')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
