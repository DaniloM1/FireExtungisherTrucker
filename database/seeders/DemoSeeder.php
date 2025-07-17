<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exam\DocumentType;
use App\Models\Exam\ExamSubject;
use App\Models\Exam\ExamGroup;
use App\Models\User;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tipovi dokumenata
        DocumentType::insert([
            [
                'code' => 'user_exam',
                'name' => 'Izvod diplome',
                'description' => 'Osnovni dokaz o završenoj školi'
            ],
            [
                'code' => 'company_user_exam',
                'name' => 'Lekarsko uverenje',
                'description' => 'Obavezno za polaznike'
            ],
            [
                'code' => 'company_user_exam',
                'name' => 'Prijava za ispit',
                'description' => 'Popunjena prijava za pristup ispitu'
            ],
            [
                'code' => 'user_exam',
                'name' => 'Dozvola za polaganje',
                'description' => 'Potvrda ili rešenje za izlazak na ispit'
            ],
            [
                'code' => 'user_exam',
                'name' => 'Ugovor o školovanju',
                'description' => 'Osnovni ugovor između polaznika i organizatora'
            ],
        ]);
        

        // 2. Predmeti (primeri)
        ExamSubject::insert([
            [
                'name' => 'Normativno uređenje zaštite od požara',
                'education_level' => 'ALL',
                'description' => 'Zakonski propisi i standardi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Opasne materije, požar i eksplozija',
                'education_level' => 'ALL',
                'description' => 'Osnove hemijskih opasnosti i preventivnih mera.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Preventivna zaštita od požara',
                'education_level' => 'ALL',
                'description' => 'Metode i strategije za sprečavanje incidenata.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sredstva za gašenje požara',
                'education_level' => 'ALL',
                'description' => 'Tehnologija i pravilna upotreba opreme.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vatrogasne sprave i oprema',
                'education_level' => 'ALL',
                'description' => 'Pregled opreme i njenih mogućnosti.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Taktika gašenja požara',
                'education_level' => 'ALL',
                'description' => 'Praktične tehnike i operativne procedure.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Praktični deo',
                'education_level' => 'SSS',
                'description' => 'Samo za srednju školu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Stabilni sistemi zaštite od požara',
                'education_level' => 'VSS',
                'description' => 'Integracija sistema za stalnu zaštitu. Samo za višu školu.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        

        ExamGroup::insert([
            ['name' => 'Februar 2025', 'start_date' => '2025-02-13', 'exam_date' => null, 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'Mart 2025',    'start_date' => '2025-03-15', 'exam_date' => null, 'created_at'=>now(), 'updated_at'=>now()],
        ]);

    }
}

