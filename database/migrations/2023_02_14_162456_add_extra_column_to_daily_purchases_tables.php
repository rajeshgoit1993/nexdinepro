<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtraColumnToDailyPurchasesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('daily_purchases', function (Blueprint $table) {
            $table->longText('supplier')->nullable();
            $table->longText('invoice_no')->nullable();
            $table->longText('total_gst')->nullable();
            $table->longText('total_with_gst')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=New Request, 1=Accepted Request, 2=Completed Request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('daily_purchases', function (Blueprint $table) {
            $table->dropColumn(['supplier','invoice_no','total_gst','total_with_gst','status']);
        });
    }
}
