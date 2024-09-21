<?php

namespace Database\Factories;

use App\Models\Field;
use Illuminate\Database\Eloquent\Factories\Factory;

class FieldFactory extends Factory
{
    protected $model = Field::class;

    private static $index = 0; // Static variable to keep track of the index

    public function definition()
    {
        $names = ['Grocery', 'Pharmacy', 'Restaurant', 'Store', 'Electronics', 'Furniture'];

        // Use the modulus operator to loop through names if there are more records than names
        $name = $names[self::$index % count($names)];
        self::$index++;

        return [
            'name' => $name,
            'description' => $this->faker->sentences(5, true),
        ];
    }
}
