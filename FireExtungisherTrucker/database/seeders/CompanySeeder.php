<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Location;
use App\Models\Group;
use App\Models\Device;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Kreiranje kompanija
        $companies = Company::factory(5)->create();

        $companies->each(function ($company) {
            // Kreiranje lokacija za svaku kompaniju
            $locations = Location::factory(rand(2, 5))->create([
                'company_id' => $company->id,
            ]);

            $locations->each(function ($location) {
                $groups = Group::factory(rand(1, 3))->create([
                    'location_id' => $location->id,
                ]);

                $groups->each(function ($group) {
                    Device::factory(rand(3, 10))->create([
                        'group_id' => $group->id,
                    ]);
                });
            });
        });
    }
}
