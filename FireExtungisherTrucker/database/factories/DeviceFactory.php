<?php
namespace Database\Factories;

use App\Models\Device;
use App\Models\Location;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition()
    {
        return [
            'location_id' => Location::factory(),
            // Opcionalno: slučajno dodeliti grupu ili ostaviti null
            'group_id' => $this->faker->boolean(70) ? Group::factory() : null,
            'serial_number' => $this->faker->unique()->bothify('SN-#####'),
            'model' => $this->faker->word,
            'manufacturer' => $this->faker->company,
            'manufacture_date' => $this->faker->date(),
            'next_service_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'position' => $this->faker->word,
            'hvp' => $this->faker->date(), // Može predstavljati dodatnu informaciju o lokaciji unutar objekta
            'status' => $this->faker->randomElement(['active', 'inactive', 'needs_service']),
        ];
    }
}
