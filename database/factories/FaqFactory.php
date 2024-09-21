<?php

namespace Database\Factories;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition()
    {
        return [
            'question' => $this->faker->text(100),
            'answer' => $this->faker->realText(),
            'faq_category_id' => $this->faker->numberBetween(1, 4),
        ];
    }
}
