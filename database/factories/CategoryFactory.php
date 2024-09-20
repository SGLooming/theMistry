<?php

use App\Models\Category;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Medical Services', 'Car Services', 'Laundry', 'Barber', 'Washing Dishes', 'Photography']),
        'description' => $faker->sentences(5, true),
    ];
});
