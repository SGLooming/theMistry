<?php

use App\Models\EProvider;
use App\Models\EProviderUser;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(EProviderUser::class, function (Faker $faker) {
    return [
        'user_id' => $faker->randomElement([2, 4, 6]),
        'e_provider_id' => EProvider::all()->random()->id
    ];
});
