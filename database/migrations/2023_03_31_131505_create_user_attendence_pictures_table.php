<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAttendencePicturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_attendence_pictures', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->date('login_date')->nullable();
            $table->longText('mrg_system_ip')->nullable();
            $table->longText('mrg_photo')->nullable();
            $table->time('mrg_time')->nullable();
             $table->longText('lunch_system_ip')->nullable();
            $table->longText('lunch_photo')->nullable();
            $table->time('lunch_time')->nullable();
             $table->longText('evening_system_ip')->nullable();
            $table->longText('evening_photo')->nullable();
            $table->time('evening_time')->nullable();
             $table->tinyInteger('status')->default(0)->comment('0=Not Approved, 1=Auto Full Approved,2=Admin Full Approved,3=Mrg to Lunch Approved,4=Lunch to Evening Approved');
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
        Schema::dropIfExists('user_attendence_pictures');
    }
}
