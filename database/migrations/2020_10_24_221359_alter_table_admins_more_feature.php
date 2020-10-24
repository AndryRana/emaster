<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableAdminsMoreFeature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn('categories_access');
            $table->tinyInteger('categories_view_access')->after('type');
            $table->tinyInteger('categories_edit_access')->after('categories_view_access');
            $table->tinyInteger('categories_full_access')->after('categories_edit_access');
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
            $table->dropColumn('categories_view_access');
            $table->dropColumn('categories_edit_access');
            $table->dropColumn('categories_full_access');
            $table->dropColumn('users_access');
        });
    }
}
