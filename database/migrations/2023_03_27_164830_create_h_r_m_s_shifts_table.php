<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHRMSShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('h_r_m_s_shifts', function (Blueprint $table) {
            $table->id();
            $table->longText('shift_name')->nullable();
            $table->time('login_time')->nullable();
            $table->time('logout_time')->nullable();
            $table->longText('lunch_duration')->nullable();
            $table->longText('login_variance')->nullable();
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
        Schema::dropIfExists('h_r_m_s_shifts');
    }
}
