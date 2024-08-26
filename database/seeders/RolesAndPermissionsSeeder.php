<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $pers = [
            'dashboard' => [
                'access-dashboard',
                'dashboard-manage',
            ],
            'user' => [
                'user-manage',
                'user-add',
                'user-edit',
                'user-delete',
                'user-impersonate',
                'user-access-dashboard',
            ],
            'activity' => [
                'activity-manage',
                'activity-add',
                'activity-edit',
                'activity-delete',
            ],
            'permission' => [
                'permission-manage',
                'permission-add',
                'permission-edit',
                'permission-delete',
                'permission-change',
            ],
            'role' => [
                'role-manage',
                'role-add',
                'role-edit',
                'role-delete',
                'role-change',
            ],
            'backup' => [
                'backup-manage',
                'backup-delete',
            ],
            'visitor' => [
                'visitor-manage',
                'visitor-delete',
            ],
            'setting' => [
                'setting-manage',
                'language-manage',
            ],
            'exam' => [
                'exam-manage',
                'exam-add',
                'exam-edit',
                'exam-delete',
            ],
            'subject' => [
                'subject-manage',
                'subject-add',
                'subject-edit',
                'subject-delete',
            ],
            'rank' => [
                'rank-manage',
                'rank-add',
                'rank-edit',
                'rank-delete',
            ],
            'mark-distribution' => [
                'mark-distribution-manage',
                'mark-distribution-add',
                'mark-distribution-edit',
                'mark-distribution-delete',
            ],
            'question' => [
                'question-manage',
                'question-add',
                'question-edit',
                'question-delete',
            ],
            'question-generate' => [
                'question-generate-manage',
                'question-generate-add',
                'question-generate-edit',
                'question-generate-delete',
                'question-generate-generate',
            ],
            'question-paper' => [
                'question-paper-manage',
                'question-paper-add',
                'question-paper-edit',
                'question-paper-delete',
            ],
        ];
        foreach ($pers as $per => $val) {
            foreach ($val as $name) {
                Permission::create([
                    'module' => $per,
                    'name' => $name,
                    'removable' => 0,
                ]);
            }
        }

        $superadmin = Role::create(['name' => 'super_admin','removable'=> 0]);
        $admin = Role::create(['name' => 'admin', 'removable' => 0]);
        $admin->givePermissionTo(Permission::all());
        // $teacher = Role::create(['name' => 'user', 'removable' => 0]);
    }
}
