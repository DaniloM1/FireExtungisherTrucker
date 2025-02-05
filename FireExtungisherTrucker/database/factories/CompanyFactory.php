<?php
namespace Database\Factories;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company,
            'address' => $this->faker->address,
            'contact_email' => $this->faker->companyEmail,
            'contact_phone' => $this->faker->phoneNumber,
            'pib' => $this->faker->unique()->numerify('########'),
            'maticni_broj' => $this->faker->unique()->numerify('######'),
            'website' => $this->faker->url,
        ];
    }
}
