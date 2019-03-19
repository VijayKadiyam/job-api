<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('me', 'MeController@me');

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/reset_password','Auth\ResetPasswordController@reset_password');
Route::post('login', 'Auth\LoginController@login');
Route::post('/logout','Auth\LoginController@logout');
Route::get('/logout','Auth\LoginController@logout');

Route::resource('roles', 'RolesController');
Route::resource('role_user', 'RoleUserController');

Route::resource('leave_patterns', 'LeavePatternsController');
Route::resource('holidays', 'HolidaysController');
Route::resource('permissions', 'PermissionsController');
Route::resource('permission_role', 'PermissionRoleController');

Route::resource('users', 'UsersController');

Route::resource('companies', 'CompaniesController');
Route::resource('company_user', 'CompanyUserController');
Route::resource('company_states', 'CompanyStatesController');
Route::resource('break_types', 'BreakTypesController');
Route::resource('allowance_types', 'AllowanceTypesController');
Route::resource('transport_modes', 'TransportModesController');
Route::resource('feedbacks', 'FeedbacksController');
Route::resource('plans', 'PlansController');
Route::resource('companies/{company}/company_designations', 'CompanyDesignationsController');
Route::resource('company_states/{company_state}/company_state_branches', 'CompanyStateBranchesController');
Route::resource('company_states/{company_state}/company_state_holidays', 'CompanyStateHolidaysController');

Route::resource('company_leave_pattern', 'CompanyLeavePatternController');
Route::resource('company_leaves', 'CompanyLeavesController');

Route::resource('user_attendances', 'UserAttendancesController');
Route::resource('user_attendances/{user_attendance}/user_attendance_breaks', 'UserAttendanceBreaksController');
Route::resource('user_applications', 'UserApplicationsController');
Route::resource('user_applications/{user_application}/application_approvals', 'ApplicationApprovalsController');
Route::resource('supervisor_user', 'SupervisorUsersController');

Route::resource('user_sales', 'UserSalesController');

