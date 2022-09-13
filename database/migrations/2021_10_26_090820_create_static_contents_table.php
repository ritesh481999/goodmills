<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaticContentsTable extends Migration
{
    public function up()
    {
        Schema::create('static_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id');

            $table->foreign('country_id')
                ->references('id')
                ->on('country_masters');

            $table->tinyInteger('content_type')->comment("1 - Terms And Condition / 2 - Privacy Policy / 3-Help");
            $table->text('contents');

            $table->boolean('status')
                ->default(1)
                ->comment("0 -Inactive, 1 - Active");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('static_contents');
    }
}
