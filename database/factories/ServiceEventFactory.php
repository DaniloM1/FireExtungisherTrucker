<?php
namespace Database\Factories;

use App\Models\ServiceEvent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceEventFactory extends Factory
{
    protected $model = ServiceEvent::class;

    public function definition()
    {
        return [
            'category' => $this->faker->randomElement(['pp_device', 'hydrant']),
            'service_date' => $this->faker->date(),
            'next_service_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'evid_number' => $this->faker->bothify('EV-#####'),
            'user_id' => $this->faker->numberBetween(1, 10), // ili možeš kreirati dummy korisnike
            'description' => $this->faker->sentence,
            'cost' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
