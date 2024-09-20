<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvidersFieldsToEProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('e_providers', function (Blueprint $table) {
            $table->string('aadhaar_no')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->longText('permanent_address')->nullable();
            $table->string('education')->nullable();
            $table->string('certification')->nullable();
            $table->string('services')->nullable();
            $table->longText('work_address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('years_of_experience')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('address_proof')->nullable();
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
            $table->dropColumn([
                'aadhaar_no',  'dob', 'gender', 'permanent_address', 'education', 'certification', 'services',
                'work_address',
                'pincode', 'years_of_experience',
                'id_proof', 'address_proof',
            ]);
        });
    }
}
