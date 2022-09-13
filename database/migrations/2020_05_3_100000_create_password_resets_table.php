<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token', 255);

            $table->string('otp', 8)
                ->nullable();

            $table->timestamp('generate_at')
                ->nullable();

            $table->timestamp('created_at')
                ->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('password_resets');
    }
}
