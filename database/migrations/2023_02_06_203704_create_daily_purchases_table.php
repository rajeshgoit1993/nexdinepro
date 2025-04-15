<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_purchases', function (Blueprint $table) {
            $table->id();
            $table->longText('reference_no')->nullable();
            $table->date('date')->nullable();
            $table->longText('subtotal')->nullable();
            $table->longText('other')->nullable();
            $table->longText('grand_total')->nullable();
            $table->longText('paid')->nullable();
            $table->longText('due')->nullable();
            $table->longText('note')->nullable();
            $table->longText('any_doc')->nullable();
            $table->longText('user_id')->nullable();
            $table->longText('outlet_id')->nullable();
            $table->longText('del_status')->nullable();
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
        Schema::dropIfExists('daily_purchases');
    }
}
