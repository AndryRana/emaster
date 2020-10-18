<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableCmsPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cms_pages', function (Blueprint $table) {
            $table->string('meta_title');
            $table->string('meta_description');
            $table->string('meta_keywords');
        });
    }
}
