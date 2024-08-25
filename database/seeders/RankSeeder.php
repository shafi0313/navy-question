<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            [
                'name' => 'ডিই/ইউসি',
            ],
            [
                'name' => 'ইউসি',
            ],
        ];
        Rank::insert($ranks);
    }
}
