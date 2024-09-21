<?php

namespace Database\Factories;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition()
    {
        return [
            'eservice_id' => $this->faker->numberBetween(1, 30),
            'user_id' => $this->faker->numberBetween(1, 6),
        ];
    }
}
