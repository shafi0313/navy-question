<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exams = [
            ['name' => 'বাংলাদেশ নৌবাহিনী নাবিক ভর্তি পরীক্ষা'],
        ];

        Exam::insert($exams);
    }
}
