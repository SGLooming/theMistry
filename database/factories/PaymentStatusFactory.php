<?php

namespace Database\Factories;

use App\Models\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentStatusFactory extends Factory
{
    protected $model = PaymentStatus::class;

    public function definition()
    {
        return [
            'status' => $this->faker->text(48),
            'order' => $this->faker->numberBetween(1, 10),
        ];
    }

    public function statusMoreThan127Chars()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => $this->faker->paragraph(20),
            ];
        });
    }
}
