<?php
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

Route::group(['middleware' => ['auth:api'], 'prefix' => 'v1'], function () {
    Route::get('/roles', 'RoleController@getRoles')->name('roles');
    Route::get('/users', 'UserController@getUsers')->name('users');
    Route::get('/assets', 'AssetController@getAssets')->name('assets');
    Route::apiResource('/asset_categories', 'AssetCategoryController');
    Route::get('/requests', 'AssetRequestController@getRequests')->name('requests');
    Route::get('/assignments', 'AssignmentController@getAssignments')->name('assignments');
    Route::get('/assignment_requests', 'AssignmentController@getRequests')->name('assignment_requests');
});
