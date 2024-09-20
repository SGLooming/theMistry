<?php
/*
 * File name: FaqsTableSeeder.php
 * Last modified: 2021.03.01 at 21:56:10
 * Copyright (c) 2021
 */

use App\Models\Faq;
use Illuminate\Database\Seeder;

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
        factory(Faq::class, 30)->create();
    }
}
