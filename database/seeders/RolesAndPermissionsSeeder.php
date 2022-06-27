<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoleToPermission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'dashboard'=>[
                'access-dashboard',
                'dashboard-manage',
            ],
            'activity'=>[
                'activity-manage',
                'activity-add',
                'activity-edit',
                'activity-delete'
            ],
            'user'=>[
                'user-manage',
                'user-add',
                'user-edit',
                'user-delete',
                'user-impersonate',
                'user-access-dashboard',
            ],
            'permission'=>[
                'permission-manage',
                'permission-add',
                'permission-edit',
                'permission-delete',
                'permission-change'
            ],
            'role'=>[
                'role-manage',
                'role-add',
                'role-edit',
                'role-delete'
            ],
            'subscribe-plan'=>[
                'subscribe-plan-manage',
                'subscribe-plan-add',
                'subscribe-plan-edit',
                'subscribe-plan-delete'
            ],
            'subscribed-user'=>[
                'subs-user-manage',
                'subs-user-add',
                'subs-user-edit',
                'subs-user-delete'
            ],
            'checkout'=>[
                'checkout-manage',
                'checkout-add',
                'checkout-edit',
                'checkout-delete'
            ],
            'app-setting'=>[
                'app-setting-manage',
                'app-setting-add',
                'app-setting-edit',
                'app-setting-delete'
            ],
            'article' => [
                'article-manage',
                'article-add',
                'article-edit',
                'article-delete',
            ],
            'category' => [
                'category-manage',
                'category-add',
                'category-edit',
                'category-delete',
            ],
            'navigation' => [
                'navigation-manage',
                'navigation-add',
                'navigation-edit',
                'navigation-delete',
            ],
            'department' => [
                'department-manage',
                'department-add',
                'department-edit',
                'department-delete',
            ],
            'knowledge-base' => [
                'knowledge-base-manage',
                'knowledge-base-add',
                'knowledge-base-edit',
                'knowledge-base-delete',
            ],
            'support' => [
                'support-manage',
                'support-add',
                'support-edit',
                'support-delete',
            ],
            'ticket' => [
                'ticket-manage',
                'ticket-add',
                'ticket-edit',
                'ticket-delete',
            ],
            'ads-plugin' => [
                'ads-manage',
                'ads-add',
                'ads-edit',
                'ads-delete',
            ],
            'student' => [
                'student-manage',
                'student-add',
                'student-edit',
                'student-delete',
            ],
            'admission' => [
                'admission-manage',
                'admission-add',
                'admission-edit',
                'admission-delete',
            ],
            'teacher' => [
                'teacher-manage',
                'teacher-add',
                'teacher-edit',
                'teacher-delete',
            ],
            'parent' => [
                'parent-manage',
                'parent-add',
                'parent-edit',
                'parent-delete',
            ],
            'accountant' => [
                'accountant-manage',
                'accountant-add',
                'accountant-edit',
                'accountant-delete',
            ],
            'attendance' => [
                'attendance-manage',
                'attendance-add',
                'attendance-edit',
                'attendance-delete',
            ],
            'bio-attendance' => [
                'bio-attendance-manage',
                'bio-attendance-add',
                'bio-attendance-edit',
                'bio-attendance-delete',
            ],
            'class-routine' => [
                'class-routine-manage',
                'class-routine-add',
                'class-routine-edit',
                'class-routine-delete',
            ],
            'subject' => [
                'subject-manage',
                'subject-add',
                'subject-edit',
                'subject-delete',
            ],
            'syllabus' => [
                'syllabus-manage',
                'syllabus-add',
                'syllabus-edit',
                'syllabus-delete',
            ],
            'class' => [
                'class-manage',
                'class-add',
                'class-edit',
                'class-delete',
            ],
            'class-room' => [
                'class-room-manage',
                'class-room-add',
                'class-room-edit',
                'class-room-delete',
            ],
            'event-calender' => [
                'event-calender-manage',
                'event-calender-add',
                'event-calender-edit',
                'event-calender-delete',
            ],
            'mark' => [
                'mark-manage',
                'mark-add',
                'mark-edit',
                'mark-delete',
            ],
            'exam' => [
                'exam-manage',
                'exam-add',
                'exam-edit',
                'exam-delete',
            ],
            'grade' => [
                'grade-manage',
                'grade-add',
                'grade-edit',
                'grade-delete',
            ],
            'promotion' => [
                'promotion-manage',
                'promotion-add',
                'promotion-edit',
                'promotion-delete',
            ],
            'student-fee' => [
                'student-fee-manage',
                'student-fee-add',
                'student-fee-edit',
                'student-fee-delete',
            ],
            'income-manage'=>[
                'income-manage-manage',
                'income-manage-add',
                'income-manage-edit',
                'income-manage-delete'
            ],
            'income-category'=>[
                'income-category-manage',
                'income-category-add',
                'income-category-edit',
                'income-category-delete'
            ],
            'expense-manage'=>[
                'expense-manage',
                'expense-manage-add',
                'expense-manage-edit',
                'expense-manage-delete'
            ],
            'expense-category'=>[
                'expense-category-manage',
                'expense-category-add',
                'expense-category-edit',
                'expense-category-delete'
            ],
            'library'=>[
                'office-manage',
                'library-manage',
                'booklist-manage',
                'booklist-add',
                'booklist-edit',
                'booklist-delete',
                'bookissue-manage',
                'bookissue-add',
                'bookissue-edit',
                'bookissue-delete',
            ],
            'session'=>[
                'session-manage',
                'session-add',
                'session-edit',
                'session-delete'
            ],
            'noticeboard'=>[
                'noticeboard-manage',
                'noticeboard-add',
                'noticeboard-edit',
                'noticeboard-delete'
            ],
            'pages'=>[
                'pages-manage',
                'pages-add',
                'pages-edit',
                'pages-delete'
            ],
            'send-sms'=>[
                'send-sms-manage',
                'send-sms-add',
                'send-sms-edit',
                'send-sms-delete'
            ],
            'setting'=>[
                'setting-manage',
                'system-manage',
                'sms-manage',
                'website-manage',
                'school-manage',
                'payment-manage',
                'language-manage',
                'smtp-manage',
                'about-manage',
            ],
        ];
        foreach ($pers as $per => $val) {
            foreach ($val as $name) {
                Permission::create([
                    'module'        => $per,
                    'name'          => $name,
                    'removable'     => 0,
                ]);
            }
        }


        $superadmin = Role::create(['name' => 'superadmin','removable'=> 0]);
        $admin      = Role::create(['name' => 'admin','removable'=> 0]);
        $admin->givePermissionTo(Permission::all());
        $teacher    = Role::create(['name' => 'teacher','removable'=> 0]);
        $student    = Role::create(['name' => 'student','removable'=> 0]);
        $parent     = Role::create(['name' => 'parent','removable'=> 0]);
        $accountant = Role::create(['name' => 'accountant','removable'=> 0]);
        $librarian  = Role::create(['name' => 'librarian','removable'=> 0]);
    }
}
