<?php
/*
 * File name: 2021_04_11_090930_edit_columns_availability_hours_table.php
 * Last modified: 2021.05.07 at 19:12:31
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsAvailabilityHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('availability_hours')) {
            Schema::table('availability_hours', function (Blueprint $table) {
                $table->longText('data')->nullable()->change();
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
