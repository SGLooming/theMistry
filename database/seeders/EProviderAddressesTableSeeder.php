<?php
/*
 * File name: EProviderAddressesTableSeeder.php
 * Last modified: 2021.04.20 at 11:19:32
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Exception;
use Illuminate\Database\Seeder;
use App\Models\EProviderAddress;
use Illuminate\Support\Facades\DB;

class EProviderAddressesTableSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('e_provider_addresses')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        try {
            EProviderAddress::factory()->count(10)->create();
        } catch (Exception $e) {
        }
    }
}
