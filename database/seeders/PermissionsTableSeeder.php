<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 18,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 19,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 20,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 21,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 22,
                'title' => 'department_access',
            ],
            [
                'id'    => 23,
                'title' => 'department_create',
            ],
            [
                'id'    => 24,
                'title' => 'department_edit',
            ],
            [
                'id'    => 25,
                'title' => 'department_delete',
            ],
            [
                'id'    => 26,
                'title' => 'department_show',
            ],
            [
                'id'    => 27,
                'title' => 'channel_access',
            ],
            [
                'id'    => 28,
                'title' => 'channel_create',
            ],
            [
                'id'    => 29,
                'title' => 'channel_edit',
            ],
            [
                'id'    => 30,
                'title' => 'channel_delete',
            ],
            [
                'id'    => 31,
                'title' => 'channel_show',
            ],
            [
                'id'    => 32,
                'title' => 'boost_access',
            ],
            [
                'id'    => 33,
                'title' => 'boost_create',
            ],
            [
                'id'    => 34,
                'title' => 'boost_edit',
            ],
            [
                'id'    => 35,
                'title' => 'boost_delete',
            ],
            [
                'id'    => 36,
                'title' => 'boost_show',
            ],
            [
                'id'    => 37,
                'title' => 'boost_reviewer',
            ],
            [
                'id'    => 38,
                'title' => 'boost_approver',
            ],
            [
                'id'    => 39,
                'title' => 'boost_admin',
            ],
            [
                'id'    => 40,
                'title' => 'boost_reviewer_edit',
            ],
            [
                'id'    => 41,
                'title' => 'boost_approver_edit',
            ],
            [
                'id'    => 42,
                'title' => 'boost_approver_admin',
            ],
            [
                'id'    => 43,
                'title' => 'boost_request',
            ],
            [
                'id'    => 44,
                'title' => 'position_access',
            ],
            [
                'id'    => 45,
                'title' => 'position_create',
            ],
            [
                'id'    => 46,
                'title' => 'position_edit',
            ],
            [
                'id'    => 47,
                'title' => 'position_delete',
            ],
            [
                'id'    => 48,
                'title' => 'position_show',
            ],
            [
                'id'    => 49,
                'title' => 'employee_access',
            ],
            [
                'id'    => 50,
                'title' => 'employee_create',
            ],
            [
                'id'    => 51,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 52,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 53,
                'title' => 'employee_show',
            ],
            [
                'id'    => 54,
                'title' => 'hr_admin',
            ],
            [
                'id'    => 55,
                'title' => 'boost_admin',
            ],
            [
                'id'    => 56,
                'title' => 'line_manager_access',
            ],
            [
                'id'    => 57,
                'title' => 'line_manager_create',
            ],
            [
                'id'    => 58,
                'title' => 'line_manager_edit',
            ],
            [
                'id'    => 59,
                'title' => 'line_manager_delete',
            ],
            [
                'id'    => 60,
                'title' => 'line_manager_show',
            ],
            [
                'id'    => 61,
                'title' => 'leave_type_access',
            ],
            [
                'id'    => 62,
                'title' => 'leave_type_create',
            ],
            [
                'id'    => 63,
                'title' => 'leave_type_edit',
            ],
            [
                'id'    => 64,
                'title' => 'leave_type_delete',
            ],
            [
                'id'    => 65,
                'title' => 'leave_type_show',
            ],
        ];

        Permission::insert($permissions);
    }
}