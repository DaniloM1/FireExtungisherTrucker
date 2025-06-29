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
            ['code' => 'global',   'name' => 'Globalni dokument',   'description' => 'Važi za sve korisnike'],
            ['code' => 'company',  'name' => 'Dokument firme',      'description' => 'Specifično za firmu'],
            ['code' => 'group',    'name' => 'Dokument grupe',      'description' => 'Za članove određene grupe'],
            ['code' => 'subject',  'name' => 'Dokument predmeta',   'description' => 'Za određeni predmet'],
            ['code' => 'user',     'name' => 'Lični dokument',      'description' => 'Prilog uz korisnika'],
        ]);

        // 2. Predmeti (primeri)
        ExamSubject::insert([
            ['name' => 'Osnove zaštite',     'education_level' => 'ALL', 'description' => 'Osnovni predmet za sve', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'PP Aparati',         'education_level' => 'ALL', 'description' => '', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'Evakuacija',         'education_level' => 'ALL', 'description' => '', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'Praktični deo',      'education_level' => 'SSS', 'description' => 'Samo za srednju školu', 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'Stabilni sistemi',   'education_level' => 'VSS', 'description' => 'Samo za višu školu',    'created_at'=>now(), 'updated_at'=>now()],
        ]);

        // 3. Grupe (primeri)
        ExamGroup::insert([
            ['name' => 'Februar 2025', 'start_date' => '2025-02-13', 'exam_date' => null, 'created_at'=>now(), 'updated_at'=>now()],
            ['name' => 'Mart 2025',    'start_date' => '2025-03-15', 'exam_date' => null, 'created_at'=>now(), 'updated_at'=>now()],
        ]);

    }
}

