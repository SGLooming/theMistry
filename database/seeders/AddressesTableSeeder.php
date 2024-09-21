<?php
/*
 * File name: AddressesTableSeeder.php
 * Last modified: 2021.02.01 at 21:46:26
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('addresses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Address::factory()->count(18)->create();


    }
}
