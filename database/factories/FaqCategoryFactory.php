<?php
namespace Database\Factories;

use App\Models\FaqCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqCategoryFactory extends Factory
{
    protected $model = FaqCategory::class;

    public function definition()
    {
        $names = ['Service', 'Payment', 'Support', 'Providers', 'Misc'];
        return [
            'name' => $this->faker->randomElement($names), 
        ];
    }
}
