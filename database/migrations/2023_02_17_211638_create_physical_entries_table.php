<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhysicalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('physical_entries', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable();
            $table->integer('outlet_id')->nullable();
            $table->integer('ingredient_id')->nullable();
            $table->longText('auto_data')->nullable();
            $table->longText('physical_data')->nullable();
            $table->tinyInteger('sync_status')->default(0)->comment('0=Not Sync, 1=Sync');
            $table->tinyInteger('entry_type')->default(0)->comment('0=Auto, 1=Manual');
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
        Schema::dropIfExists('physical_entries');
    }
}
