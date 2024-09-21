<?php
/*
 * File name: BookingsTableSeeder.php
 * Last modified: 2021.03.01 at 21:41:49
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('bookings')->delete();
    }
}
