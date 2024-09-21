<?php
/*
 * File name: GalleriesTableSeeder.php
 * Last modified: 2021.03.01 at 21:23:22
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GalleriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('galleries')->delete();
        Gallery::factory()->count(20)->create();

    }
}
