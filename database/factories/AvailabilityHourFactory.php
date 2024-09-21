<?php

namespace Database\Factories;

use App\Models\AvailabilityHour;
use App\Models\EProvider;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AvailabilityHourFactory extends Factory
{
    protected $model = AvailabilityHour::class;

    public function definition()
    {
        return [
            'day' => Str::lower($this->faker->randomElement(Carbon::getDays())),
            'start_at' => str_pad($this->faker->numberBetween(2, 12), 2, '0', STR_PAD_LEFT) . ":00",
            'end_at' => $this->faker->numberBetween(13, 23) . ":00",
            'data' => $this->faker->text(50),
            'e_provider_id' => EProvider::all()->random()->id,
        ];
    }

    public function dayMore16Char()
    {
        return $this->state(function (array $attributes) {
            return [
                'day' => $this->faker->paragraph(3),
            ];
        });
    }

    public function endAtLessThanStartAt()
    {
        return $this->state(function (array $attributes) {
            return [
                'start_at' => $this->faker->numberBetween(16, 21) . ":20",
                'end_at' => $this->faker->numberBetween(10, 13) . ":30",
            ];
        });
    }

    public function notExistEProviderId()
    {
        return $this->state(function (array $attributes) {
            return [
                'e_provider_id' => 500000, // non-existent ID
            ];
        });
    }
}
