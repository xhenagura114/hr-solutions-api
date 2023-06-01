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
    Route::post('login', 'PassportController@login');
    Route::post('signup', 'PassportController@signup');

    Route::group([
        'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'PassportController@logout');
        Route::get('user', 'PassportController@user');
    });

    Route::group([
        'prefix' => 'dashboard'
    ], function () {
        Route::post('new-employees', 'DashboardController@newEmployees');
        Route::post('new-applicants', 'DashboardController@newApplicants');
        Route::post('new-events', 'DashboardController@newEvents');
        Route::post('job-vacancies ', 'DashboardController@jobVacancies');
        Route::post('users-per-departments', 'DashboardController@usersDepartments');
        Route::post('organigram ', 'DashboardController@organigram');
        Route::post('recruitment  ', 'DashboardController@recruitment');
});