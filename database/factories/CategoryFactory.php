<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement([
                'Medical Services',
                'Car Services',
                'Laundry',
                'Barber',
                'Washing Dishes',
                'Photography'
            ]),
            'description' => $this->faker->sentences(5, true),
        ];
    }
}
