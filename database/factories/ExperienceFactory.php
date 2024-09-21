<?php

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition()
    {
        return [
            'title' => $this->faker->text(127),
            'description' => $this->faker->realText(),
            'e_provider_id' => EProvider::all()->random()->id,
        ];
    }

    public function titleMore127Char()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => $this->faker->paragraph(20),
            ];
        });
    }

    public function notExistEProviderId()
    {
        return $this->state(function (array $attributes) {
            return [
                'e_provider_id' => 500000, // non-existent ID
            ];
        });
    }
}
