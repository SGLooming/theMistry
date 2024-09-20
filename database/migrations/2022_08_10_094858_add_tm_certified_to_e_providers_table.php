<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTmCertifiedToEProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add tm_certified (The Mistry Certified) Column to the e_providers table.
        Schema::table('e_providers', function (Blueprint $table) {
            $table->boolean('tm_certified')->nullable()->default(0)->after('accepted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('e_providers', function (Blueprint $table) {
            $table->dropColumn('tm_certified');
        });
    }
}
