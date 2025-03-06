<?php
namespace Database\Factories;

use App\Models\ElectricalInspection;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class ElectricalInspectionFactory extends Factory
{
    protected $model = ElectricalInspection::class;

    public function definition()
    {
        return [
            'location_id' => Location::factory(),
            'inspection_date' => $this->faker->date(),
            'next_inspection_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'description' => $this->faker->sentence,
            'cost' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}
