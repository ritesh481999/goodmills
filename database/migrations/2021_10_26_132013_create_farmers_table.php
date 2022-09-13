<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmersTable extends Migration
{
    public function up()
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('username')->unique();
            $table->string('company_name');
            $table->string('registration_number',12)->nullable();
            $table->string('business_partner_id',20)->nullable();
            $table->string('email')->unique();
            $table->string('pin', 100);
            $table->string('dialing_code', 10);
            $table->string('phone', 14);
            $table->string('address');
            $table->unsignedBigInteger('country_id');
            $table->text('aditional_details')->nullable();
            $table->foreign('country_id')
                ->references('id')
                ->on('country_masters');

            $table->string('user_type')
                ->comment("Producer, Trader, Others");

            $table->dateTime('block_login_time')->nullable();

            $table->boolean('is_news_sms')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            $table->boolean('is_marketing_sms')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            $table->boolean('is_bids_received_sms')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            $table->boolean('is_news_notification')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            $table->boolean('is_marketing_notification')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            $table->boolean('is_bids_received_notification')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            // $table->boolean('mobile_verified')
            //     ->default(0)
            //     ->comment("0 - No / 1 - Yes");

            $table->timestamp('last_login_at')->nullable();
            $table->string('reason')->nullable();
             $table->date('scheduled_deleted_date')->nullable();
            $table->boolean('is_suspend')
                ->default(0)
                ->comment("0 - No / 1 - Yes");

            $table->boolean('status')
                ->default(0)
                ->comment("0 - Inactive / 1 - Active");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('farmers');
    }
}
