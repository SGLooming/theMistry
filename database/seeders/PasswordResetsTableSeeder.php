<?php
/*
 * File name: PasswordResetsTableSeeder.php
 * Last modified: 2021.03.01 at 21:35:31
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class PasswordResetsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('password_resets')->delete();
    }
}
