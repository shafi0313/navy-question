<?php

namespace Database\Seeders;

use App\Models\Rank;
use Illuminate\Database\Seeder;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            ['name' => 'ডিই/ইউসি', 'created_at' => '2025-01-11 09:59:14', 'updated_at' => '2025-01-11 09:59:14', 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['name' => 'মেডিক্যাল', 'created_at' => '2025-01-11 09:59:14', 'updated_at' => '2025-01-11 09:59:14', 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['name' => 'স্টোর/রাইটার/পেট্রোলম্যান/এমওডিসি(নৌ)', 'created_at' => '2025-01-11 09:59:14', 'updated_at' => '2025-01-11 09:59:14', 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['name' => 'কুক/ স্টুয়ার্ড', 'created_at' => '2025-01-11 09:59:14', 'updated_at' => '2025-01-11 09:59:14', 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['name' => 'টোপাস', 'created_at' => '2025-01-11 09:59:14', 'updated_at' => '2025-01-11 09:59:14', 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
            ['name' => 'এমওডিসি', 'created_at' => '2025-01-11 09:59:14', 'updated_at' => '2025-01-11 09:59:14', 'created_by' => null, 'updated_by' => null, 'deleted_at' => null],
        ];
        Rank::insert($ranks);
    }
}
