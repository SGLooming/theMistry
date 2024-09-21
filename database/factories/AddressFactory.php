<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'description' => $this->faker->randomElement(['Work', 'Home', 'Office', 'Workshop', 'Building', 'Hotel']),
            'address' => $this->faker->address,
            'latitude' => $this->faker->randomFloat(8, 50, 52),
            'longitude' => $this->faker->randomFloat(8, 9, 12),
            'user_id' => User::all()->random()->id,
        ];
    }

    public function more255Char()
    {
        return $this->state(function (array $attributes) {
            return [
                'description' => $this->faker->paragraph(30),
                'address' => $this->faker->paragraph(30),
                'latitude' => 210,
                'longitude' => -203,
            ];
        });
    }

    public function empty()
    {
        return $this->state(function (array $attributes) {
            return [
                'address' => null,
                'latitude' => null,
                'longitude' => null,
            ];
        });
    }
}
