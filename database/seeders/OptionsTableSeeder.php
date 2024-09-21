<?php
/*
 * File name: OptionsTableSeeder.php
 * Last modified: 2021.03.01 at 21:57:23
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Option;

class OptionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('options')->delete();
        Option::factory()->count(100)->create();

    }
}
