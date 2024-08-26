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
        $admin = User::create([
            'name' => 'Developer',
            'email' => 'admin@app.com',
            'permission' => '1',
            'password' => bcrypt('##Zxc1234'),
        ]);
        $admin->assignRole(['super_admin']);
    }
}
