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
        $admins = [
            [
                'name' => 'Super Admin',
                'email' => 's_admin@app.com',
                'permission' => 1,
                'password' => bcrypt('##Zxc1234'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@app.com',
                'permission' => 2,
                'password' => bcrypt('##Zxc1234'),
            ],
            [
                'name' => 'User',
                'email' => 'user@app.com',
                'permission' => 3,
                'password' => bcrypt('##Zxc1234'),
            ],
        ];
        User::insert($admins);
    }
}
