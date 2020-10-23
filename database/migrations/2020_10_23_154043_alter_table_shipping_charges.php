<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableShippingCharges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->integer('shipping_charges0_500g');
            $table->integer('shipping_charges501_1000g');
            $table->integer('shipping_charges1001_2000g');
            $table->integer('shipping_charges2001g_5000g');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shipping_charges', function (Blueprint $table) {
            $table->dropColumn('shipping_charges0_500g');
            $table->dropColumn('shipping_charges501_1000g');
            $table->dropColumn('shipping_charges1001_2000g');
            $table->dropColumn('shipping_charges2001g_5000g');
        });
    }
}
