<?php

use Illuminate\Database\Seeder;

class Updatev200Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTableV200Seeder::class);
    }
}
