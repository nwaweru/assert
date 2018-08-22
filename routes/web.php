<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

Auth::routes();
Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser')->name('users.verify');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/requests/cancel/{uuid}', 'AssetRequestController@cancel')->name('requests.cancel');
    Route::put('/requests/cancel/{uuid}', 'AssetRequestController@cancelRequest')->name('requests.cancel');
    Route::get('/requests/reject/{uuid}', 'AssetRequestController@reject')->name('requests.reject');
    Route::put('/requests/reject/{uuid}', 'AssetRequestController@rejectRequest')->name('requests.reject');
    Route::get('/requests/accept/{uuid}', 'AssetRequestController@accept')->name('requests.accept');
    Route::put('/requests/accept/{uuid}', 'AssetRequestController@acceptRequest')->name('requests.accept');
    Route::resource('requests', 'AssetRequestController')->only(['index', 'create', 'store']);

    Route::get('/assignments/clear/{uuid}', 'AssignmentController@clear')->name('assignments.clear');
    Route::put('/assignments/clear/{uuid}', 'AssignmentController@clearAssignment')->name('assignments.clear');

    Route::resources([
        'roles' => 'RoleController',
        'users' => 'UserController',
        'assets' => 'AssetController',
        'assignments' => 'AssignmentController',
    ]);

    Route::get('/asset_categories', function() {
        return view('asset_categories.index');
    })->name('asset_categories');
});
