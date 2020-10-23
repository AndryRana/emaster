<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdmins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->enum('type',['Admin','Sub Admin'])->after('status');
            $table->tinyInteger('categories_access')->after('type');
            $table->tinyInteger('products_access')->after('categories_access');
            $table->tinyInteger('orders_access')->after('products_access');
            $table->tinyInteger('users_access')->after('orders_access');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('categories_access');
            $table->dropColumn('products_access');
            $table->dropColumn('orders_access');
            $table->dropColumn('users_access');
        });
    }
}
