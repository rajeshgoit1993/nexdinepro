<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewRegistrationsFieldsToFanchiseRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fanchise_registrations', function (Blueprint $table) {
            //
            $table->longText('firm_name')->nullable();
            $table->longText('gst_number')->nullable();
            $table->longText('outlet_address')->nullable();
            $table->longText('subscription_type')->nullable();
            $table->bigInteger('subscription_value')->nullable();
            $table->date('advance_reveived_date')->nullable();
            
            $table->date('expire_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fanchise_registrations', function (Blueprint $table) {
            //
        });
    }
}
