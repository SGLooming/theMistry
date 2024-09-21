<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\EServiceReview;

class EServiceReviewsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('e_service_reviews')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Correct usage of the factory method
        EServiceReview::factory()->count(100)->create();
    }
}
