<?php

namespace Database\Factories\Exam;

use App\Models\Exam\ExamGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamGroupFactory extends Factory
{
    protected $model = ExamGroup::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'start_date' => $this->faker->date(),
            'exam_date' => $this->faker->date(),
        ];
    }
}
