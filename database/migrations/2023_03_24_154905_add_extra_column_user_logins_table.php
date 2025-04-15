<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnUserLoginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_logins', function (Blueprint $table) {
            $table->longText('login_accuracy')->nullable();
            $table->longText('login_distance_office')->nullable();
            $table->longText('logout_distance_office')->nullable();
            $table->longText('logout_accuracy')->nullable();
            $table->longText('office_latitude')->nullable();
            $table->longText('office_longitude')->nullable();
            $table->longText('office_location')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=Not Approved, 1=Approved');
            $table->longText('shift_id')->nullable();
            $table->longText('assign_login_time')->nullable();
            $table->longText('assign_logout_time')->nullable();
            $table->longText('lunch_time')->nullable();
            $table->longText('login_variance')->nullable();
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
            $table->dropColumn(['login_accuracy','login_distance_office','logout_distance_office','logout_accuracy','office_latitude','office_longitude','office_location','status','shift_id','assign_login_time','assign_logout_time','lunch_time','login_variance']);
        });
    }
}
