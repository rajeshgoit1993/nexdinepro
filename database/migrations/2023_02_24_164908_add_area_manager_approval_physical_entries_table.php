<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAreaManagerApprovalPhysicalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('physical_entries', function (Blueprint $table) {
            $table->tinyInteger('area_manager_approval')->default(0)->comment('0=Not Approved, 1=Approved');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('area_manager_approval', function (Blueprint $table) {
            $table->dropColumn('sync_status');
        });
    }
}
