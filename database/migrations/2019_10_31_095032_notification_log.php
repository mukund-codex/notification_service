<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NotificationLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('notification_log', function(Blueprint $table){
            $table->integer('notification_id')->autoIncrement();
            $table->string('request_ id');
            $table->string('uid');
            $table->string('device_id');
            $table->string('device_type');
            $table->string('title');
            $table->string('callback');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('notification_log');
    }
}
