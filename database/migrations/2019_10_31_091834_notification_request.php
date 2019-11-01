<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NotificationRequest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('notification_request', function(Blueprint $table){
            $table->integer('id')->autoIncrement();
            $table->string('request_ id');
            $table->string('uid');
            $table->string('device_id');
            $table->string('device_type');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->string('pdf_file');
            $table->string('ppt_file');
            $table->string('video_file');
            $table->string('file_type');
            $table->string('download_status');
            $table->string('request_status');
            $table->string('callback');
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
        Schema::dropIfExists('notification_request');
    }
}
