<?php
/*
 * File name: UploadsTableSeeder.php
 * Last modified: 2021.03.01 at 21:37:55
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class UploadsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('uploads')->delete();
    }
}
