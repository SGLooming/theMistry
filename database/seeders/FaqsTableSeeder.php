<?php
/*
 * File name: FaqsTableSeeder.php
 * Last modified: 2021.03.01 at 21:56:10
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class FaqsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::table('faqs')->delete();
        Faq::factory()->count(30)->create();
    }

    // if not work use this

    // public function run()
    // {
    //     // Clear existing records
    //     DB::table('faqs')->delete();
    //     DB::table('faq_categories')->delete(); // Clear categories too if needed

    //     // Create some FAQ categories
    //     $categories = FaqCategory::factory()->count(5)->create();

    //     // Create FAQs and assign random category IDs from existing categories
    //     Faq::factory()->count(30)->create([
    //         'faq_category_id' => $categories->random()->id,
    //     ]);
    // }
}
