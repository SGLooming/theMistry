<?php

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factory;

global $i;
$i = 0;

/** @var Factory $factory */
$factory->define(FaqCategory::class, function () use ($i) {
    $names = ['Service', 'Payment', 'Support', 'Providers', 'Misc'];
    return [
        'name' => $names[$i++],
    ];
});
