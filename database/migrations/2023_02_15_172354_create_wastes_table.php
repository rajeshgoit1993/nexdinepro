<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWastesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id')->nullable();
            $table->date('date')->nullable();
            $table->longText('total_loss')->nullable();
            $table->tinyInteger('sync_status')->default(0)->comment('0=Not Sync, 1=Sync');
            $table->tinyInteger('loss_type')->default(0)->comment('0=Ingredient Wise, 1=Food Menu Wise');
            
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
        Schema::dropIfExists('wastes');
    }
}
