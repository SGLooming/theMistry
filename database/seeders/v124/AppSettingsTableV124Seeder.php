<?php

use Illuminate\Database\Seeder;

class AppSettingsTableV124Seeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::table('app_settings')->insert(array(
            array(
                'key' => 'provider_app_name',
                'value' => 'Service Provider',
            ),
        ));
    }
}
