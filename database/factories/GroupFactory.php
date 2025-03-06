<?php
namespace Database\Factories;

use App\Models\Group;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition()
    {
        return [
            'location_id' => Location::factory(), // Veza ka lokaciji
            'name' => $this->faker->word, // Može biti npr. "Hala 1"
            'description' => $this->faker->sentence,
        ];
    }
}
