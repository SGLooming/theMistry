<?php

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;

class GalleryFactory extends Factory
{
    protected $model = Gallery::class;

    public function definition()
    {
        return [
            'description' => $this->faker->sentence,
            'e_provider_id' => EProvider::all()->random()->id,
        ];
    }
}
