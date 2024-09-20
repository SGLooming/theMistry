<?php
/*
 * File name: 2021_04_12_090930_edit_columns_booking_statuses_table.php
 * Last modified: 2021.05.07 at 19:12:31
 * Copyright (c) 2021
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditColumnsBookingStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('booking_statuses')) {
            Schema::table('booking_statuses', function (Blueprint $table) {
                $table->longText('status')->nullable()->change();
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
