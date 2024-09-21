<?php

namespace Database\Factories;

use App\Models\EService;
use App\Models\EServiceReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EServiceReviewFactory extends Factory
{
    protected $model = EServiceReview::class;

    public function definition()
    {
        return [
            'review' => $this->faker->realText(100),
            'rate' => $this->faker->numberBetween(1, 5),
            'user_id' => User::role('customer')->get()->random()->id,
            'e_service_id' => EService::all()->random()->id,
        ];
    }
}
