<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\EProvider;
use App\Models\EServiceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class EServiceCategoryFactory extends Factory
{
    protected $model = EServiceCategory::class;

    public function definition()
    {
        return [
            'category_id' => Category::all()->random()->id,
            'e_service_id' => EProvider::all()->random()->id,
        ];
    }
}
