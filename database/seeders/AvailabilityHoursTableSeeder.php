<?php
/*
 * File name: AvailabilityHoursTableSeeder.php
 * Last modified: 2021.02.01 at 22:22:23
 * Copyright (c) 2021
 */
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\AvailabilityHour;

class AvailabilityHoursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('availability_hours')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Use the new factory method
        AvailabilityHour::factory()->count(50)->create();
    }
}
