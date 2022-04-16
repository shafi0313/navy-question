<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Developer',
                'email' => 'dev.admin@shafi95.com',
                'permission' => 1,
                'password' =>  bcrypt('##Zxc1234'),
            ],
            [
                'name' => 'Developer',
                'email' => 'dev.user@shafi95.com',
                'permission' => 2,
                'password' =>  bcrypt('##Zxc1234'),
            ]
        ];
        User::insert($user);
    }
}
