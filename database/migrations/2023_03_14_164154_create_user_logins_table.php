<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->longText('system_ip')->nullable();
            $table->integer('user_id')->nullable();
            $table->dateTime('login_date_time')->nullable();
            $table->date('login_date')->nullable();
            $table->time('login_time')->nullable();
            $table->longText('login_latitude')->nullable();
            $table->longText('login_longitude')->nullable();
            $table->longText('login_location')->nullable();
            $table->time('logout_time')->nullable();
            $table->dateTime('logout_date_time')->nullable();
            $table->longText('logout_latitude')->nullable();
            $table->longText('logout_longitude')->nullable();
            $table->longText('logout_location')->nullable();
            $table->tinyInteger('logout_type')->default(0)->comment('0=Not Logout, 1=Manual,2=Auto');

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
        Schema::dropIfExists('user_logins');
    }
}
