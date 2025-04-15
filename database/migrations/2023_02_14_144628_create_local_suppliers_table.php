<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('local_suppliers', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id')->nullable();
            $table->longText('supplier_name')->nullable();
            $table->longText('phone_no')->nullable();
            $table->longText('mail_id')->nullable();
            $table->longText('address')->nullable();
            $table->longText('pincode')->nullable();
            $table->longText('gst_no')->nullable();
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
        Schema::dropIfExists('local_suppliers');
    }
}
