<?php

use App\Models\PaymentStatus;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

/** @var Factory $factory */
$factory->define(PaymentStatus::class, function (Faker $faker) {
    return [
        'status' => $faker->text(48),
        'order' => $faker->numberBetween(1, 10)
    ];
});

$factory->state(PaymentStatus::class, 'status_more_127_char', function (Faker $faker) {
    return [
        'status' => $faker->paragraph(20),
    ];
});
