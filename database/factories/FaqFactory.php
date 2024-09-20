<?php

use App\Models\Faq;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(Faq::class, function (Faker $faker) {
    return [
        'question' => $faker->text(100),
        'answer' => $faker->realText(),
        'faq_category_id' => $faker->numberBetween(1, 4)
    ];
});
