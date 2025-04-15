<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLunchTimeUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->time('lunch_start_time')->nullable();
            $table->time('lunch_end_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->dropColumn(['lunch_start_time','lunch_end_time']);
        });
    }
}
