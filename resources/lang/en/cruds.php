<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission' => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => ' ',
            'title'              => 'Title',
            'title_helper'       => ' ',
            'permissions'        => 'Permissions',
            'permissions_helper' => ' ',
            'created_at'         => 'Created at',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => ' ',
            'name'                     => 'Name',
            'name_helper'              => ' ',
            'email'                    => 'Email',
            'email_helper'             => ' ',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Password',
            'password_helper'          => ' ',
            'roles'                    => 'Roles',
            'roles_helper'             => ' ',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Created at',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
            'profile'                  => 'Profile',
            'profile_helper'        => ' ',
        ],
    ],
    'userAlert' => [
        'title'          => 'User Alerts',
        'title_singular' => 'User Alert',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'alert_text'        => 'Alert Text',
            'alert_text_helper' => ' ',
            'alert_link'        => 'Alert Link',
            'alert_link_helper' => ' ',
            'user'              => 'Users',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'department' => [
        'title'          => 'Departments',
        'title_singular' => 'Department',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'head'             => 'Head Department',
            'head_helper'      => ' ',
            
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'channel' => [
        'title'          => 'Channels',
        'title_singular' => 'Channel',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'description'             => 'Channel Description',
            'description_helper'      => ' ',
            
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'boost' => [
        'title'          => 'Boosts',
        'title_singular' => 'Boost',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'description'             => 'Boost Description',
            'description_helper'      => ' ',
            'requester_name'          => 'Requester Name',
            'requester_name_helper'   => ' ',
            'company_name'            => 'Client',
            'company_name_helper'     => ' ',
            'group'                   => 'Group',
            'group_helper'            => ' ',
            'budget'                  => 'Budget',
            'budget_helper'           => ' ',
            'reference'               => 'Reference',
            'reference_helper'        => ' ',
            'program_name'            => 'Program Name',
            'program_name_helper'     => ' ',
            'target_url'              => 'Target URL',
            'target_url_helper'       => ' ',
            'boost_start'             => 'Boost Start',
            'boost_start_helper'      => ' ',
            'boost_end'               => 'Boost End',
            'boost_end_helper'        => ' ',
            'detail'                  => 'Detail',
            'detail_helper'           => ' ',
            'status'                  => 'Status',
            'status_helper'           => ' ',
            'actual_cost'                  => 'Actual Cost',
            'actual_cost_helper'           => ' ',
            'channel'                   => 'Channel',
            'channel_helper'            => ' ',
            'review_by'                 => 'Review By',
            'approve_by'                => 'Approve By',
            'reason'                    => 'Reason',
            'channel_helper'            => ' ',
            'created_at'        => 'Requested at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
        ],
    ],
    'position' => [
        'title'             => 'Positions',
        'title_singular'    =>'Position',
        'fields'            => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'department'        => 'Department',
            'department_helper' => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',

            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
    'employee' => [
        'title'              => 'Employees',
        'title_singular'     => 'Employee',
        'fields'             => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'empId'             => 'Employee ID',
            'empId_helper'      => ' ',
            'first_name'        => 'First Name',
            'first_name_helper' => ' ',
            'last_name'         => 'Last Name',
            'last_name_helper'  => ' ',
            'gender'            => 'Gender',
            'gender_helper'     => ' ',
            'eligible'          => 'Eligible',
            'eligible_helper'   => ' ',
            'hire_date'         => 'Hire Date',
            'hire_date_helper'  => ' ',
            'position'          => 'Position',
            'position_helper'   => ' ',
            'departement'          => 'Departement',
            'departement_helper'   => ' ',
            'user'              => 'User',
            'user_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ', 
        ],
    ],
    'lineManager' => [
        'title'             => 'Line Managers',
        'title_singular'    => 'Line Manager',
        'fields'            => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'lineManager'        => 'Line Manager',
            'lineManager_helper' => ' ',
            'head'              => 'Head',
            'head_helper'       => ' ',
            'department_head'              => 'Department Head',
            'department_head_helper'       => ' ',
            'remark'              => 'Remark',
            'remark_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],
    'leaveType' => [
        'title'             => 'Leave Types',
        'title_singular'    => 'Leave Type',
        'fields'            => [
            'id'                => 'ID',
            'id_helper'         => ' ',
            'title'             => 'Title',
            'title_helper'      => ' ',
            'default_dur'              => 'Default Duration',
            'default_dur_helper'       => ' ',
            'created_at'        => 'Created at',
            'created_at_helper' => ' ',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => ' ',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => ' ',
        ],
    ],

];