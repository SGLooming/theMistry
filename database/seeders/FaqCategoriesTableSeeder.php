<?php
/*
 * File name: FaqCategoriesTableSeeder.php
 * Last modified: 2021.03.01 at 21:56:10
 * Copyright (c) 2021
 */
namespace Database\Seeders;

use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\FaqCategoryFactory;

class FaqCategoriesTableSeeder extends Seeder
{

   /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FaqCategory::query()->delete();

        $names = ['Service', 'Payment', 'Support', 'Providers', 'Misc'];

        foreach ($names as $name) {
            FaqCategory::create(['name' => $name]);
        }
    }
}
