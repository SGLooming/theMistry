<?php

namespace Database\Factories;

use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;

    public function definition()
    {
        return [
            'name' => $this->faker->text(48),
            'description' => $this->faker->sentence(5),
            'route' => $this->faker->randomElement(['/PayPal', '/RazorPay', '/CashOnDelivery', '/Strip']),
            'order' => $this->faker->numberBetween(1, 10),
            'default' => $this->faker->boolean(),
            'enabled' => $this->faker->boolean(),
        ];
    }

    public function nameMoreThan127Chars()
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => $this->faker->paragraph(20),
            ];
        });
    }

    public function descriptionMoreThan127Chars()
    {
        return $this->state(function (array $attributes) {
            return [
                'description' => $this->faker->paragraph(20),
            ];
        });
    }

    public function routeMoreThan127Chars()
    {
        return $this->state(function (array $attributes) {
            return [
                'route' => $this->faker->paragraph(20),
            ];
        });
    }

    public function orderNegative()
    {
        return $this->state(function (array $attributes) {
            return [
                'order' => -1,
            ];
        });
    }
}
