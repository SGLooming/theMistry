<?php

namespace Database\Factories;

use App\Models\EService;
use App\Models\Option;
use App\Models\OptionGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class OptionFactory extends Factory
{
    protected $model = Option::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['10m²', '20m', '30m²', '40m']),
            'description' => $this->faker->sentence(4),
            'price' => $this->faker->randomFloat(2, 10, 50),
            'e_service_id' => EService::all()->random()->id,
            'option_group_id' => OptionGroup::all()->random()->id,
        ];
    }
}
