<?php
namespace Database\Factories;

use App\Models\Hydrant;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class HydrantFactory extends Factory
{
    protected $model = Hydrant::class;

    public function definition()
    {
        return [
            'location_id' => Location::factory(),
            'serial_number' => $this->faker->unique()->bothify('HYD-#####'),
            'type' => $this->faker->randomElement(['Type A', 'Type B', 'Type C']),
            'model' => $this->faker->word,
            'manufacturer' => $this->faker->company,
            'manufacture_date' => $this->faker->date(),
            'next_service_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'position' => $this->faker->word,
            'hvp' => $this->faker->date(),
            'static_pressure' => $this->faker->randomFloat(2, 1, 10),
            'dynamic_pressure' => $this->faker->randomFloat(2, 1, 10),
            'flow' => $this->faker->randomFloat(2, 100, 1000),
            'status' => $this->faker->randomElement(['active', 'inactive', 'needs_service']),
        ];
    }
}
