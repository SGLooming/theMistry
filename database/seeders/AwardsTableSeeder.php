<?php
/*
 * File name: AwardsTableSeeder.php
 * Last modified: 2021.03.01 at 21:40:37
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Award;

class AwardsTableSeeder extends Seeder
{

      /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('awards')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Use the factory method to create 50 awards
        Award::factory()->count(50)->create();
    }
}
