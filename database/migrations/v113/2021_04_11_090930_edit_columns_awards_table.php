<?php
/*
 * File name: 2021_04_11_090930_edit_columns_awards_table.php
 * Last modified: 2021.05.07 at 19:12:31
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('awards')) {
            Schema::table('awards', function (Blueprint $table) {
                $table->longText('title')->nullable()->change();
                $table->longText('description')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
