<?php

use Illuminate\Database\Seeder;

class Updatev121Seeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PaymentMethodsTableV121Seeder::class);
        $this->call(PermissionsTableV121Seeder::class);
        $this->call(RoleHasPermissionsTableV121Seeder::class);
        $this->call(WalletsTableSeeder::class);
        $this->call(WalletTransactionsTableSeeder::class);
    }
}
