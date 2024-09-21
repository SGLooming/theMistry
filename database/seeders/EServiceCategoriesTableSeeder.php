<?php
/*
 * File name: EServiceCategoriesTableSeeder.php
 * Last modified: 2021.03.02 at 14:35:42
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Exception;
use Illuminate\Database\Seeder;
use App\Models\EServiceCategory;
use Illuminate\Support\Facades\DB;

class EServiceCategoriesTableSeeder extends Seeder
{

       /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('e_service_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        try {
            EServiceCategory::factory()->count(10)->create();
        } catch (Exception $e) {
            // Optionally handle the exception
        }
    }

}
