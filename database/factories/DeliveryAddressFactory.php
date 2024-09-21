<?php

namespace Database\Factories;

use App\Models\DeliveryAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeliveryAddressFactory extends Factory
{
    protected $model = DeliveryAddress::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'address' => $this->faker->address,
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'is_default' => $this->faker->boolean,
            'user_id' => $this->faker->numberBetween(1, 6),
        ];
    }
}
