<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(RolesAndPermissionsSeeder::class);
        $this->call([
            UserSeeder::class,
            // ExamSeeder::class,
            RankSeeder::class,
            SubjectSeeder::class,
            QuestionSeeder::class,
            QuesOptionSeeder::class,
            // MarkDistributionSeeder::class,
        ]);
    }
}
