<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyncTypeWasteIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('waste_ingredients', function (Blueprint $table) {
           $table->tinyInteger('sync_status')->default(0)->comment('0=Not Sync, 1=Sync');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('waste_ingredients', function (Blueprint $table) {
            $table->dropColumn('sync_status');
        });
    }
}
