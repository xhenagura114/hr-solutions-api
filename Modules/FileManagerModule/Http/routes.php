<?php

Route::group(['middleware' => ['web', 'revalidate', 'LoginMiddleware','PermissionsMiddleware'], 'prefix' => 'file-manager', 'namespace' => 'Modules\FileManagerModule\Http\Controllers'], function()
{
    Route::get('/', 'FileManagerModuleController@index')->name('module.file-manager.home');
});
