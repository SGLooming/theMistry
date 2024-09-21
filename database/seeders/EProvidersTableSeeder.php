<?php
/*
 * File name: EProvidersTableSeeder.php
 * Last modified: 2021.03.02 at 11:28:53
 * Copyright (c) 2021
 */
namespace Database\Seeders;
use Exception;
use App\Models\EProvider;
use App\Models\EProviderUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EProvidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('e_providers')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        EProvider::factory()->count(18)->create();

        try {
            EProviderUser::factory()->count(10)->create();
        } catch (\Exception $e) {
        }

    }
}
