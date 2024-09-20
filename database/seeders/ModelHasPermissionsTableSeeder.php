<?php
/*
 * File name: ModelHasPermissionsTableSeeder.php
 * Last modified: 2021.03.01 at 21:23:22
 * Copyright (c) 2021
 */

use Illuminate\Database\Seeder;

class ModelHasPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('model_has_permissions')->delete();
    }
}
