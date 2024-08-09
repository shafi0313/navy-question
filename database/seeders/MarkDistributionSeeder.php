<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarkDistribution;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MarkDistributionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mark_distributions = array(
            array('id' => '1','subject_id' => '1','multiple' => '20','sort' => '0','long' => '0','created_at' => '2024-08-09 18:27:15','updated_at' => '2024-08-09 18:27:15'),
            array('id' => '2','subject_id' => '2','multiple' => '20','sort' => '0','long' => '0','created_at' => '2024-08-09 18:27:15','updated_at' => '2024-08-09 18:27:15'),
            array('id' => '3','subject_id' => '3','multiple' => '20','sort' => '0','long' => '0','created_at' => '2024-08-09 18:27:15','updated_at' => '2024-08-09 21:26:40'),
            array('id' => '4','subject_id' => '4','multiple' => '20','sort' => '0','long' => '0','created_at' => '2024-08-09 18:27:15','updated_at' => '2024-08-09 21:26:40'),
            array('id' => '5','subject_id' => '5','multiple' => '20','sort' => '0','long' => '0','created_at' => '2024-08-09 18:27:15','updated_at' => '2024-08-09 21:26:40')
          );
          MarkDistribution::insert($mark_distributions);
    }
}
