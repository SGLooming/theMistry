<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
        ];
    }

    public function register()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->name,
                'password' => bcrypt('123456'), // Hash the password
            ];
        });
    }

    public function login()
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => bcrypt('123456'), // Hash the password
            ];
        });
    }
}
