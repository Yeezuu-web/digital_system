<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Admin\{
    HomeController,
    RolesController,
    UsersController,
    BoostsController,
    ChannelsController,
    EmployeesController,
    PositionsController,
    UserAlertsController,
    DepartmentsController,
    PermissionsController,
    BoostsUpdateController,
    LineManagersController,
    LeaveTypesController,
    HolidaysController,
    LeaveRequestsController,
    HrReportsController
};

Route::redirect('/', '/system/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::view('boosts/request/thankyou', 'partials.thankyou')->name('thankyou');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class , 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class , 'massDestroy'])->name('users.massDestroy');
    Route::post('users/media', [UsersController::class, 'storeMedia'])->name('users.storeMedia');
    Route::post('users/ckmedia', [UsersController::class, 'storeCKEditorImages'])->name('users.storeCKEditorImages');
    Route::resource('users', UsersController::class);

    // User Alerts
    Route::delete('user-alerts/destroy', [UserAlertsController::class , 'massDestroy'])->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', [UserAlertsController::class , 'read']);
    Route::resource('user-alerts', UserAlertsController::class)->except(['edit', 'update']);
    Route::view('alerts', 'partials.alert-read')->name('alert.read');

    // Departmnt
    Route::delete('departments/destroy', [DepartmentsController::class , 'massDestroy'])->name('departments.massDestroy');
    Route::resource('departments', DepartmentsController::class);
    
    // Channel
    Route::delete('channels/destroy', [ChannelsController::class , 'massDestroy'])->name('channels.massDestroy');
    Route::resource('channels', ChannelsController::class);

    // Position
    Route::delete('positions/destroy', [PositionsController::class , 'massDestroy'])->name('positions.massDestroy');
    Route::resource('positions', PositionsController::class);

    // Holiday
    Route::delete('holidays/destroy', [HolidaysController::class , 'massDestroy'])->name('holidays.massDestroy');
    Route::resource('holidays', HolidaysController::class);

    //Employee
    Route::delete('employees/destroy', [EmployeesController::class, 'massDestroy'])->name('employees.massDestroy');
    Route::resource('employees', EmployeesController::class);
    
    // boost
    Route::delete('boosts/destroy', [BoostsController::class , 'massDestroy'])->name('boosts.massDestroy');
    Route::get('boosts/{boost}/firstApprove', [BoostsController::class , 'firstApprove'])->name('boosts.firstApprove');
    Route::post('boosts/firstApprove/update/{boost}', [BoostsController::class , 'firstApproveUpdate'])->name('boosts.firstApproveUpdate');
    Route::get('boosts/{boost}/secondApprove', [BoostsController::class , 'secondApprove'])->name('boosts.secondApprove');
    Route::post('boosts/secondApprove/update/{boost}', [BoostsController::class , 'secondApproveUpdate'])->name('boosts.secondApproveUpdate');
    //boost request
    Route::get('boosts/send-mail', [BoostsController::class, 'basic_email'])->name('boosts.send_mail');
    Route::post('boosts/media', [BoostsController::class, 'storeMedia'])->name('boosts.storeMedia');
    Route::post('boosts/ckmedia', [BoostsController::class, 'storeCKEditorImages'])->name('boosts.storeCKEditorImages');
    Route::get('boosts/requestIndex', [BoostsController::class , 'requestIndex'])->name('boosts.requestIndex');
    Route::get('boosts/requestIndex/create', [BoostsController::class , 'boostRequest'])->name('boosts.request');
    Route::post('boosts/requestIndex/store', [BoostsController::class , 'boostStore'])->name('boosts.request.store');
    Route::resource('boosts', BoostsController::class)->except(['create', 'store']);
    
    
    // production
    Route::delete('productins/destroy', [BoostsUpdateController::class , 'massDestroy'])->name('productins.massDestroy');
    Route::get('productions', [BoostsUpdateController::class , 'index'])->name('productions.index');
    Route::get('productions/edit/{id}', [BoostsUpdateController::class , 'edit'])->name('productions.edit');
    Route::post('productions/update/{id}', [BoostsUpdateController::class , 'update'])->name('productions.update');
    
    // boosts report
    Route::get('reports/boost', [BoostsUpdateController::class , 'index'])->name('reports.boosts.index');

    // line manager
    Route::delete('lineManagers/destroy', [LineManagersController::class , 'massDestroy'])->name('lineManagers.massDestroy');
    Route::resource('lineManagers', LineManagersController::class);

    // leave type
    Route::delete('leaveTypes/destroy', [LeaveTypesController::class , 'massDestroy'])->name('leaveTypes.massDestroy');
    Route::resource('leaveTypes', LeaveTypesController::class);

    // leave request
    Route::delete('leaveRequests/destroy', [LeaveRequestsController::class , 'massDestroy'])->name('leaveRequests.massDestroy');
    Route::get('leaveRequests/{leaveRequest}/firstApprove', [LeaveRequestsController::class , 'firstApprove'])->name('leaveRequests.firstApprove');
    Route::post('leaveRequests/firstApprove/update/{leaveRequest}', [LeaveRequestsController::class , 'firstApproveUpdate'])->name('leaveRequests.firstApproveUpdate');
    Route::get('leaveRequests/{leaveRequest}/secondApprove', [LeaveRequestsController::class , 'secondApprove'])->name('leaveRequests.secondApprove');
    Route::post('leaveRequests/secondApprove/update/{leaveRequest}', [LeaveRequestsController::class , 'secondApproveUpdate'])->name('leaveRequests.secondApproveUpdate');
    Route::post('leaveRequests/approve', [LeaveRequestsController::class , 'approve'])->name('leaveRequests.approve');
    Route::get('leaveRequests/record', [LeaveRequestsController::class , 'record'])->name('leaveRequests.record');
    Route::post('leaveRequests/media', [LeaveRequestsController::class, 'storeMedia'])->name('leaveRequests.storeMedia');
    Route::post('leaveRequests/ckmedia', [LeaveRequestsController::class, 'storeCKEditorImages'])->name('leaveRequests.storeCKEditorImages');
    Route::resource('leaveRequests', LeaveRequestsController::class);

    // leave request report
    Route::get('hr/report', [HrReportsController::class, 'index'])->name('hr.report');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class , 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class , 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class , 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/media', [ChangePasswordController::class, 'storeMedia'])->name('password.storeMedia');
        Route::post('profile/destroy', [ChangePasswordController::class , 'destroy'])->name('password.destroyProfile');
    }
});