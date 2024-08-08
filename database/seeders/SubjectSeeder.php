<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            [
                'exam_id' => 1,
                'name' => 'বাংলা',
            ],
            [
                'exam_id' => 1,
                'name' => 'ইংরেজি',
            ],
            [
                'exam_id' => 1,
                'name' => 'গণিত',
            ],
            [
                'exam_id' => 1,
                'name' => 'বিজ্ঞান',
            ],
            [
                'exam_id' => 1,
                'name' => 'সাধারণ জ্ঞান ও বুদ্ধিমত্তা',
            ],
        ];
        Subject::insert($subjects);
    }
}
