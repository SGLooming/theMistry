<?php
/*
 * File name: FavoriteOptionsTableSeeder.php
 * Last modified: 2021.03.01 at 21:22:30
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class FavoriteOptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorite_options')->delete();
    }
}
