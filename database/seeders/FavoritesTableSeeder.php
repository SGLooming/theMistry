<?php
/*
 * File name: FavoritesTableSeeder.php
 * Last modified: 2021.03.02 at 14:35:34
 * Copyright (c) 2021
 */

 namespace Database\Seeders;
 use Illuminate\Support\Facades\DB;
 use Illuminate\Database\Seeder;

class FavoritesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->delete();
    }
}
