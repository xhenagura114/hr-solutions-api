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

Route::get('/login', 'HomeController@login');
Route::post("authenticate", 'AuthController@authenticate')->name('module.authentication.login');
Route::get('forget-password', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('forget-password');
Route::post('forget-password',  'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post'); 
Route::get('reset-password/{token}', 'Auth\ResetPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password','Auth\ResetPasswordController@submitResetPasswordForm')->name('reset.password.post');

Route::group(['middleware' =>  ['web', 'LoginMiddleware','PermissionsMiddleware']], function () {

    Route::get('/', 'HomeController@index')->name('system.module.home');

    Route::get('/logout', 'AuthController@logout')->name('module.authentication.logout');

    Route::get("count-birthdays", "HomeController@countBirthdays")->name('user.birthday.count');

    Route::get("count-prehired", "HomeController@countPreHired")->name('user.prehired.count');

    Route::get("prehired", "HomeController@listPreHired")->name('user.prehired.list');

    Route::get("birthdays", "HomeController@listBirthdays")->name('user.birthday.list');

    Route::get("make-wish/{type}/{id}", "HomeController@makeWish")->name('user.birthday.make-wish');
});
