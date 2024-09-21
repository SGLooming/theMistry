<?php

namespace Database\Factories;

use App\Models\EProvider;
use App\Models\EService;
use App\Models\Slide;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlideFactory extends Factory
{
    protected $model = Slide::class;

    public function definition()
    {
        $eService = $this->faker->boolean;

        return [
            'order' => $this->faker->numberBetween(0, 5),
            'text' => $this->faker->sentence(4),
            'button' => $this->faker->randomElement(['Discover It', 'Book Now', 'Get Discount']),
            'text_position' => $this->faker->randomElement(['start', 'end', 'center']),
            'text_color' => '#25d366',
            'button_color' => '#25d366',
            'background_color' => '#ccccdd',
            'indicator_color' => '#25d366',
            'image_fit' => 'cover',
            'e_service_id' => $eService ? EService::all()->random()->id : null,
            'e_provider_id' => !$eService ? EProvider::all()->random()->id : null,
            'enabled' => $this->faker->boolean,
        ];
    }
}
