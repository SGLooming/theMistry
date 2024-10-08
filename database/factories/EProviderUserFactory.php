<?php

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\EProviderUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class EProviderUserFactory extends Factory
{
    protected $model = EProviderUser::class;

    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement([2, 4, 6]),
            'e_provider_id' => EProvider::all()->random()->id,
        ];
    }
}
