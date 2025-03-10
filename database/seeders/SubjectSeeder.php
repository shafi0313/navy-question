<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['rank_id' => '4', 'name' => 'বাংলা', 'created_at' => null, 'updated_at' => null, 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['rank_id' => '4', 'name' => 'ইংরেজি', 'created_at' => null, 'updated_at' => null, 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['rank_id' => '4', 'name' => 'গণিত', 'created_at' => null, 'updated_at' => null, 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['rank_id' => '4', 'name' => 'বিজ্ঞান', 'created_at' => null, 'updated_at' => null, 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['rank_id' => '4', 'name' => 'সাধারণ জ্ঞান ও বুদ্ধিমত্তা', 'created_at' => null, 'updated_at' => null, 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
        ];
        Subject::insert($subjects);
    }
}
