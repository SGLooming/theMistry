<?php
/*
 * File name: NotificationsTableSeeder.php
 * Last modified: 2021.03.01 at 21:24:33
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class NotificationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->delete();
    }
}
