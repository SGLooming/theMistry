<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEServiceProviderReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('e_service_provider_reviews', function (Blueprint $table) {
            $table->id();
            $table->text('review')->nullable();
            $table->decimal('rate', 3, 2)->default(0);
            $table->bigInteger('user_id')->unsigned();
            $table->integer('e_provider_id')->unsigned();
            $table->integer('e_service_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('e_provider_id')->references('id')->on('e_providers');
            $table->foreign('e_service_id')->references('id')->on('e_services')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('e_service_provider_reviews');
    }
}
