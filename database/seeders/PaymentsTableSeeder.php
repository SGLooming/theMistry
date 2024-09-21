<?php
/*
 * File name: PaymentsTableSeeder.php
 * Last modified: 2021.03.01 at 21:35:31
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->delete();
    }
}
