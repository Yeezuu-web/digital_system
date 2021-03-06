<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            {{ trans('panel.site_title') }}
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item {{ request()->is("admin") ? "active" : "" }}">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">{{ trans('global.dashboard') }}</span>
                </a>
            </li>
            @can('hr_admin')
                <li class="nav-item nav-category">HR System</li>
                @can('department_access') 
                    <li class="nav-item {{ request()->is("admin/departments") || request()->is("admin/departments/*") ? "active" : "" }}">
                        <a href="{{ route("admin.departments.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="trello"></i>
                            <span class="link-title">{{ trans('global.department') }}</span>
                        </a>
                    </li>
                @endcan
                @can('position_access') 
                    <li class="nav-item {{ request()->is("admin/positions") || request()->is("admin/positions/*") ? "active" : "" }}">
                        <a href="{{ route("admin.positions.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="package"></i>
                            <span class="link-title">{{ trans('global.position') }}</span>
                        </a>
                    </li>
                @endcan
                @can('employee_access') 
                    <li class="nav-item {{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "active" : "" }}">
                        <a href="{{ route("admin.employees.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="user"></i>
                            <span class="link-title">{{ trans('global.employee') }}</span>
                        </a>
                    </li>
                @endcan
                @can('line_manager_access') 
                    <li class="nav-item {{ request()->is("admin/lineManagers") || request()->is("admin/lineManagers/*") ? "active" : "" }}">
                        <a href="{{ route("admin.lineManagers.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="user"></i>
                            <span class="link-title">{{ trans('global.lineManager') }}</span>
                        </a>
                    </li>
                @endcan
                @can('leave_type_access') 
                    <li class="nav-item {{ request()->is("admin/leaveTypes") || request()->is("admin/leaveTypes/*") ? "active" : "" }}">
                        <a href="{{ route("admin.leaveTypes.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="list"></i>
                            <span class="link-title">{{ trans('global.leave_type') }}</span>
                        </a>
                    </li>
                @endcan
                @can('holiday_access') 
                    <li class="nav-item {{ request()->is("admin/holidays") || request()->is("admin/holidays/*") ? "active" : "" }}">
                        <a href="{{ route("admin.holidays.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="calendar"></i>
                            <span class="link-title">{{ trans('global.holiday') }}</span>
                        </a>
                    </li>
                @endcan
                @can('leave_request_access') 
                    <li class="nav-item {{ request()->is("admin/leaveRequests") || request()->is("admin/leaveRequests/show") || request()->is("admin/leaveRequests/edit") ? "active" : "" }}">
                        <a href="{{ route("admin.leaveRequests.index") }}" class="nav-link">
                            <i class="link-icon" data-feather="bookmark"></i>
                            <span class="link-title">{{ trans('cruds.leaveRequest.menu') }}</span>
                        </a>
                    </li>
                @endcan
                @can('leave_request_record') 
                    <li class="nav-item {{ request()->is("admin/leaveRequests/record") || request()->is("admin/leaveRequests/record") ? "active" : "" }}">
                        <a href="{{ route("admin.leaveRequests.record") }}" class="nav-link">
                            <i class="link-icon" data-feather="archive"></i>
                            <span class="link-title">{{ trans('global.leave_record') }}</span>
                        </a>
                    </li>
                @endcan
                @can('leave_request_create') 
                    <li class="nav-item {{ request()->is("admin/leaveRequests/create") || request()->is("admin/leaveRequests/create") ? "active" : "" }}">
                        <a href="{{ route("admin.leaveRequests.create") }}" class="nav-link">
                            <i class="link-icon" data-feather="send"></i>
                            <span class="link-title">{{ trans('global.create_leave') }}</span>
                        </a>
                    </li>
                    @endcan
                    @can('leaveRequest_approver') 
                    <li class="nav-item {{ request()->is("admin/hr/report") ? "active" : "" }}">
                        <a href="{{ route("admin.hr.report") }}" class="nav-link">
                            <i class="link-icon" data-feather="file-text"></i>
                            <span class="link-title">{{ trans('global.report_leave') }}</span>
                        </a>
                    </li>
                @endcan
            @endcan
            <li class="nav-item nav-category">Boost System</li>
            @can('channel_access') 
                <li class="nav-item {{ request()->is("admin/channels") || request()->is("admin/channels/*") ? "active" : "" }}">
                    <a href="{{ route("admin.channels.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="tv"></i>
                        <span class="link-title">{{ trans('global.channel') }}</span>
                    </a>
                </li>
            @endcan
            @can('boost_request')
                <li class="nav-item {{ request()->is("admin/boosts/requestIndex") || request()->is("admin/boosts/requestIndex/*") ? "active" : "" }}">
                    <a href="{{ route("admin.boosts.requestIndex") }}" class="nav-link">
                        <i class="link-icon" data-feather="send"></i>
                        <span class="link-title">{{ trans('global.boost') }} Request</span>
                    </a>
                </li>
            @endcan
            @can('boost_access') 
                <li class="nav-item {{ request()->is("admin/boosts") || request()->is("admin/boosts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.boosts.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="trending-up"></i>
                        <span class="link-title">{{ trans('global.boost') }}</span>
                    </a>
                </li>
            @endcan
            @can('production_access')
                <li class="nav-item {{ request()->is("admin/productions") || request()->is("admin/boosts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.productions.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="external-link"></i>
                        <span class="link-title">{{ trans('global.production') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is("admin/reports/boosts") || request()->is("admin/reports/boosts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.reports.boosts.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="bar-chart"></i>
                        <span class="link-title">{{ trans('global.report_boost') }}</span>
                    </a>
                </li>
            @endcan
            <li class="nav-item nav-category">Settings</li>
            @can('user_management_access')
                <li class="nav-item {{ request()->is("admin/permissions*") ? "active" : "" }} {{ request()->is("admin/roles*") ? "active" : "" }} {{ request()->is("admin/users*") ? "active" : "" }}">
                    <a class="nav-link" data-toggle="collapse" href="#user-management" role="button" aria-expanded="{{ request()->is("admin/permissions*") ? "true" : "false" }} {{ request()->is("admin/roles*") ? "true" : "false" }} {{ request()->is("admin/users*") ? "true" : "false" }}" aria-controls="user-management">
                        <i class="link-icon" data-feather="users"></i>
                        <span class="link-title">{{ trans('cruds.userManagement.title') }}</span>
                        <i class="link-arrow" data-feather="chevron-down"></i>
                    </a>
                    <div class="collapse {{ request()->is("admin/permissions*") ? "show" : "" }} {{ request()->is("admin/roles*") ? "show" : "" }} {{ request()->is("admin/users*") ? "show" : "" }}" id="user-management">
                        <ul class="nav sub-menu">
                            @can('permission_access')
                            <li class="nav-item"> 
                                <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">{{ trans('cruds.permission.title') }}</a>
                            </li>
                            @endcan
                            @can('role_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">{{ trans('cruds.role.title') }}</a>
                            </li>
                            @endcan
                            @can('user_access')
                            <li class="nav-item">
                                <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">{{ trans('cruds.user.title') }}</a>
                            </li>
                            @endcan
                        </ul>
                    </div>
                </li>
            @endcan
            @can('user_alert_access')
                <li class="nav-item {{ request()->is("admin/user-alerts") || request()->is("admin/user-alerts/*") ? "active" : "" }}">
                    <a href="{{ route("admin.user-alerts.index") }}" class="nav-link">
                        <i class="link-icon" data-feather="bell"></i>
                        <span class="link-title">{{ trans('cruds.userAlert.title') }}</span>
                    </a>
                </li>
            @endcan
            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
                @can('profile_password_edit')
                    <li class="nav-item {{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}">
                        <a href="{{ route('profile.password.edit') }}" class="nav-link">
                            <i class="link-icon" data-feather="lock"></i>
                            <span class="link-title">{{ trans('global.change_password') }}</span>
                        </a>
                    </li>

                @endcan
            @endif
            <li class="nav-item nav-category">Session</li>
            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="link-icon text-danger" data-feather="log-out"></i>
                    <span class="link-title text-danger">{{ trans('global.logout') }}</span>
                </a>
            </li>
        </ul>
    </div>
</nav>
