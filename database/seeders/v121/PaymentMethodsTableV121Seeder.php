<?php

use Illuminate\Database\Seeder;

class PaymentMethodsTableV121Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert(array(
            array(
                'id' => 11,
                'name' => 'Wallet',
                'description' => 'Click to pay with Wallet',
                'route' => '/Wallet',
                'order' => 8,
                'default' => 0,
                'enabled' => 1,
                'created_at' => '2021-08-08 22:38:42',
                'updated_at' => '2021-08-08 22:38:42',
            ),
        ));


    }
}
