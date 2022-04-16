<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
            ['name' => 'index', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'create', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'edit', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'show', 'guard_name' => 'web', 'created_at' => now()],
            ['name' => 'delete', 'guard_name' => 'web', 'created_at' => now()],
        ];
        // foreach ($permissions as $permission) {
        //     $permission['guard_name'] = 'web';
        //     $permission['created_at'] =  now();
        // }

        \Spatie\Permission\Models\Permission::insert($permission);
    }
}
