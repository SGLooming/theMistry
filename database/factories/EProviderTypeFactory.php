<?php

namespace Database\Factories;

use App\Models\EProviderType;
use Illuminate\Database\Eloquent\Factories\Factory;

class EProviderTypeFactory extends Factory
{
    protected $model = EProviderType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->text(48),
            'commission' => $this->faker->randomFloat(2, 5, 50),
            'disabled' => $this->faker->boolean(),
        ];
    }

    public function nameMore127Char()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->paragraph(20),
            ];
        });
    }

    public function commissionMore100()
    {
        return $this->state(function (array $attributes) {
            return [
                'commission' => 101,
            ];
        });
    }

    public function commissionLess0()
    {
        return $this->state(function (array $attributes) {
            return [
                'commission' => -1,
            ];
        });
    }
}
