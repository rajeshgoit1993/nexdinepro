<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSyncTypeFranchiseSaleConsuptionsOfMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('franchise_sale_consuptions_of_menus', function (Blueprint $table) {
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
        Schema::table('franchise_sale_consuptions_of_menus', function (Blueprint $table) {
            $table->dropColumn('sync_status');
        });
    }
}
