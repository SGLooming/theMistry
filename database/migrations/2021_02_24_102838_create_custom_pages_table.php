<?php
/*
 * File name: 2021_02_24_102838_create_custom_pages_table.php
 * Last modified: 2021.04.20 at 11:19:32
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCustomPagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('title')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('published')->nullable()->default(0);
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
        Schema::drop('custom_pages');
    }
}
