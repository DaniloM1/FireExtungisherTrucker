<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Location;
use App\Models\Group;
use App\Models\Device;
use App\Models\Hydrant;
use App\Models\ElectricalInspection;
use App\Models\ServiceEvent;
use App\Models\LocationGroup;

class DatabaseSeeder extends Seeder
{
    /**
     * Pokretanje seeder-a.
     */
    public function run()
    {
        $this->call(\Database\Seeders\RolePermissionSeeder::class);
        // Kreiramo 5 kompanija
        Company::factory(5)->create()->each(function ($company) {
            // Za svaku kompaniju kreiramo 3 lokacije
            $locations = Location::factory(3)->create([
                'company_id' => $company->id,
            ]);

            $locations->each(function ($location) {
                // Za svaku lokaciju kreiramo 2 grupe (npr. hale)
                Group::factory(2)->create([
                    'location_id' => $location->id,
                ]);

                // Kreiramo 5 uređaja (PP aparata) za lokaciju
                Device::factory(5)->create([
                    'location_id' => $location->id,
                ]);

                // Kreiramo 2 hidranata za lokaciju
                Hydrant::factory(2)->create([
                    'location_id' => $location->id,
                ]);

                // Kreiramo jednu elektro inspekciju za lokaciju
                ElectricalInspection::factory(1)->create([
                    'location_id' => $location->id,
                ]);
            });
        });

        // Kreiramo 3 servisna događaja i nasumično vezujemo lokacije
        ServiceEvent::factory(3)->create()->each(function ($serviceEvent) {
            // Nasumično odaberemo 1 do 3 lokacije
            $locationIds = Location::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray();
            $serviceEvent->locations()->attach($locationIds);
        });

        // Kreiramo 2 grupe lokacija i nasumično vezujemo lokacije u njih
        LocationGroup::factory(2)->create()->each(function ($locationGroup) {
            // Nasumično odaberemo 2 do 5 lokacija
            $locationIds = Location::inRandomOrder()->take(rand(2, 5))->pluck('id')->toArray();
            $locationGroup->locations()->attach($locationIds);
        });
    }
}
