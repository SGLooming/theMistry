<?php

namespace Database\Factories;

use App\Models\EProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class EProviderFactory extends Factory
{
    protected $model = EProvider::class;

    public function definition()
    {
        $faker = app(Faker::class);

        return [
            'name' => $faker->randomElement([
                'Gardner Construction', 'Concrete', 'Masonry', 'House',
                'Care Services', 'Security', 'Dentists', 'Epoxy Coating',
                'Glass', 'Painting', 'Roofing', 'Sewer Cleaning', 'Architect'
            ]) . " " . $faker->company,
            'description' => $faker->text,
            'e_provider_type_id' => $faker->numberBetween(2, 3),
            'phone_number' => $faker->phoneNumber,
            'mobile_number' => $faker->phoneNumber,
            'availability_range' => $faker->randomFloat(2, 6000, 15000),
            'available' => $faker->boolean(95),
            'featured' => $faker->boolean(40),
            'accepted' => $faker->boolean(95),
        ];
    }
}
