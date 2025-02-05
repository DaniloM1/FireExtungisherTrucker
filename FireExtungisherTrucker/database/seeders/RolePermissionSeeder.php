<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Company;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // 1. Kreiranje permisija
        $permissions = [
            // Company Management
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            // Device Management
            'view devices',
            'create devices',
            'edit devices',
            'delete devices',

            // User Management
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Service Management
            'view services',
            'create services',
            'edit services',
            'delete services',

            // Audit Logs
            'view audit_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Kreiranje uloga
        $superAdminRole = Role::firstOrCreate(['name' => 'super_admin']);
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $companyRole = Role::firstOrCreate(['name' => 'company']);
        $employeeRole = Role::firstOrCreate(['name' => 'employee']);

        // 3. Dodeljivanje permisija ulogama

        // Super Admin dobija sve permisije
        $superAdminRole->syncPermissions(Permission::all());

        // Admin dobija permisije za upravljanje kompanijama, uređajima, korisnicima, servisima i pregled audit logova
        $adminRole->syncPermissions([
            'view companies',
            'create companies',
            'edit companies',
            'delete companies',

            'view devices',
            'create devices',
            'edit devices',
            'delete devices',

            'view users',
            'create users',
            'edit users',
            'delete users',

            'view services',
            'create services',
            'edit services',
            'delete services',

            'view audit_logs',
        ]);

        // Company dobija permisije za upravljanje sopstvenim uređajima i servisima
        $companyRole->syncPermissions([
            'view devices',
            'create devices',
            'edit devices',
            'delete devices',

            'view services',
            'create services',
            'edit services',
            'delete services',
        ]);

        // Employee dobija permisije za pregled i ažuriranje uređaja i servisa
        $employeeRole->syncPermissions([
            'view devices',
            'edit devices',

            'view services',
            'edit services',
        ]);

        // 4. Kreiranje kompanija
        $companies = [
            [
                'name' => 'Tech Solutions',
                'address' => '123 Tech Street',
                'contact_email' => 'contact@techsolutions.com',
                'contact_phone' => '+381123456789',
                'pib' => '123456789',
                'maticni_broj' => '987654321',
                'website' => 'https://techsolutions.com',
            ],
            [
                'name' => 'Innovate LLC',
                'address' => '456 Innovation Ave',
                'contact_email' => 'info@innovate.com',
                'contact_phone' => '+381987654321',
                'pib' => '987654321',
                'maticni_broj' => '123456789',
                'website' => 'https://innovate.com',
            ],
        ];

        foreach ($companies as $companyData) {
            Company::firstOrCreate(['pib' => $companyData['pib']], $companyData);
        }

        // 5. Kreiranje korisnika i dodeljivanje uloga

        // Super Admin korisnik
        $superAdmin = User::firstOrCreate(
            ['email' => 'danil1o@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('danilo123'), // Promeni lozinku na sigurniju
            ]
        );
        $superAdmin->assignRole($superAdminRole);

        // Admin korisnik
        $admin = User::firstOrCreate(
            ['email' => 'danilo@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('danilo123'), // Promeni lozinku na sigurniju
            ]
        );
        $admin->assignRole($adminRole);

        // Kompanijski korisnici (jedan za svaku kompaniju)
        foreach (Company::all() as $company) {
            $companyUser = User::firstOrCreate(
                ['email' => strtolower(str_replace(' ', '', $company->name)) . '@example.com'],
                [
                    'name' => $company->name . ' User',
                    'password' => bcrypt('password'), // Promeni lozinku na sigurniju
                    'company_id' => $company->id,
                ]
            );
            $companyUser->assignRole($companyRole);

            // Kreiranje zaposlenih za svaku kompaniju
            for ($i = 1; $i <= 3; $i++) {
                $employee = User::firstOrCreate(
                    ['email' => 'employee' . $i . '@' . strtolower(str_replace(' ', '', $company->name)) . '.com'],
                    [
                        'name' => 'Employee ' . $i,
                        'password' => bcrypt('password'), // Promeni lozinku na sigurniju
                        'company_id' => $company->id,
                    ]
                );
                $employee->assignRole($employeeRole);
            }
        }
    }
}
