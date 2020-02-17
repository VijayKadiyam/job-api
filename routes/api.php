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

Route::get('count', 'HomeController@count');


Route::post('/register', 'Auth\RegisterController@register');
Route::post('/reset_password','Auth\ResetPasswordController@reset_password');
Route::post('login', 'Auth\LoginController@login');
Route::post('/logout','Auth\LoginController@logout');
Route::get('/logout','Auth\LoginController@logout');

Route::resource('roles', 'RolesController');
Route::resource('role_user', 'RoleUserController');

Route::resource('permissions', 'PermissionsController');
Route::resource('permission_role', 'PermissionRoleController');

Route::resource('users', 'UsersController');

Route::resource('companies', 'CompaniesController');
Route::resource('company_user', 'CompanyUserController');
Route::resource('company_states', 'CompanyStatesController');
Route::resource('companies/{company}/company_designations', 'CompanyDesignationsController');
Route::resource('company_states/{company_state}/company_state_branches', 'CompanyStateBranchesController');

Route::resource('units', 'UnitsController');
Route::get('data', 'DatasController@storeByDevice');
Route::resource('units/{unit}/datas', 'DatasController');

// Uploads
Route::post('upload_profile_image', 'UploadController@uploadProfileImage');
Route::post('upload_profile', 'UploadController@uploadProfile');
Route::post('upload_signature', 'UploadController@uploadSignature');
Route::post('upload_bill/{id}', 'UploadController@uploadBill');
Route::post('upload_attachments', 'UploadController@uploadAttachments');

Route::post('send_email','SendEmailsController@send');
Route::resource('jobs', 'JobsController');
Route::resource('/users/{user}/branches','BranchesController');
Route::resource('/users/{user}/office_timings','OfficeTimingsController');
Route::resource('/users/{user}/leave_policies','LeavePoliciesController');
Route::resource('/jobs','JobsController');
Route::resource('/practices','PracticesController');
Route::resource('/days','DaysController');
Route::resource('/affiliations','AffiliationsController');
Route::resource('/affiliation_user','AffiliationUserController');
Route::resource('/qualifications','QualificationsController');
Route::resource('user_practice', 'UserPracticeController');
Route::resource('/user_day', 'UserDayController');
Route::resource('/job_practice', 'JobPracticeController');



