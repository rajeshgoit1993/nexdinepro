<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWasteIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waste_ingredients', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id')->nullable();
            $table->integer('food_menu_id')->nullable();
            $table->integer('ingredient_id')->nullable();
            $table->integer('waste_id')->nullable();
            $table->longText('waste_amount')->nullable();
            $table->longText('last_purchase_price')->nullable();
            $table->longText('last_purchase_price_avg')->nullable();
            $table->longText('loss_amount')->nullable();
            $table->longText('food_menu_qty')->nullable();
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
        Schema::dropIfExists('waste_ingredients');
    }
}
