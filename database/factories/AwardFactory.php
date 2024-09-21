<?php

namespace Database\Factories;

use App\Models\Award;
use App\Models\EProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class AwardFactory extends Factory
{
    protected $model = Award::class;

    public function definition()
    {
        return [
            'title' => $this->faker->text(100),
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
