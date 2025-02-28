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
        $subjects = array(
            array('rank_id' => '4','name' => 'বাংলা','created_at' => NULL,'updated_at' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_at' => NULL),
            array('rank_id' => '4','name' => 'ইংরেজি','created_at' => NULL,'updated_at' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_at' => NULL),
            array('rank_id' => '4','name' => 'গণিত','created_at' => NULL,'updated_at' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_at' => NULL),
            array('rank_id' => '4','name' => 'বিজ্ঞান','created_at' => NULL,'updated_at' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_at' => NULL),
            array('rank_id' => '4','name' => 'সাধারণ জ্ঞান ও বুদ্ধিমত্তা','created_at' => NULL,'updated_at' => NULL,'created_by' => NULL,'updated_by' => NULL,'deleted_at' => NULL)
          );;
        Subject::insert($subjects);
    }
}
