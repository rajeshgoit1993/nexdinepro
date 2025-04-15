<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShiftUserExtraDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_extra_details', function (Blueprint $table) {
           $table->integer('shift_id')->default(1);
           $table->integer('office_location_id')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_extra_details', function (Blueprint $table) {
           $table->dropColumn(['shift_id','office_location_id']);
        });
    }
}
