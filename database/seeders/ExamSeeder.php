<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = [
            [
                'name' => 'বাংলাদেশ নৌবাহিনী নাবিক ভর্তি পরীক্ষা',
                'created_by' => 1,
            ],
        ];

        Exam::insert($exams);
    }
}
