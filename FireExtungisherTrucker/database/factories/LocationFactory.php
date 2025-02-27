<?php
namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition()
    {
        return [
            'company_id' => Company::factory(), // Povezivanje sa kompanijom
            'name' => $this->faker->city,
            'address' => $this->faker->address,
            'city' => $this->faker->city, // Dodato polje za grad
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
