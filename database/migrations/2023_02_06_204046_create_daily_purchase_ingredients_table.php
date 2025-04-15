<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyPurchaseIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_purchase_ingredients', function (Blueprint $table) {
            $table->id();
            $table->integer('ingredient_id')->nullable();
            $table->longText('unit_price')->nullable();
            $table->longText('quantity_amount')->nullable();
            $table->longText('total')->nullable();
            $table->integer('purchase_id')->nullable();
            $table->integer('outlet_id')->nullable();
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
        Schema::dropIfExists('daily_purchase_ingredients');
    }
}
