<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\EProvider;
use App\Models\EProviderAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class EProviderAddressFactory extends Factory
{
    protected $model = EProviderAddress::class;

    public function definition()
    {
        return [
            'address_id' => Address::all()->random()->id,
            'e_provider_id' => EProvider::all()->random()->id,
        ];
    }
}
