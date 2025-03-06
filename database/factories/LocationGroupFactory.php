<?php
namespace Database\Factories;

use App\Models\LocationGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationGroupFactory extends Factory
{
    protected $model = LocationGroup::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word . ' Group',
            'description' => $this->faker->sentence,
        ];
    }
}
