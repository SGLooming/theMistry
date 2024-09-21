<?php
/*
 * File name: ExperiencesTableSeeder.php
 * Last modified: 2021.03.01 at 21:41:25
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Experience;

class ExperiencesTableSeeder extends Seeder
{

  /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('experiences')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Use the new factory method
        Experience::factory()->count(50)->create();
    }
}
