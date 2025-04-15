<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToDailyPurchaseIngredientsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_purchase_ingredients', function (Blueprint $table) {
           $table->longText('gst_id')->nullable();
            $table->longText('gst_percentage')->nullable();
            $table->longText('total_gst')->nullable();
            $table->longText('total_with_gst')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_purchase_ingredients', function (Blueprint $table) {
            $table->dropColumn(['gst_id','gst_percentage','total_gst','total_with_gst']);
        });
    }
}
