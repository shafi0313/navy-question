<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
            ['name' => 'admin', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'creator', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'editor', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'viewer', 'guard_name' => 'web', 'created_at' => now()],
        ];
        // foreach ($roles as $role) {
        //     $role['guard_name'] = 'web';
        //     $role['created_at'] =  now();
        // }

        \Spatie\Permission\Models\Role::insert($role);
    }
}
