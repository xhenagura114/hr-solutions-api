<?php

//self-service
Route::group(['middleware' => ['web', 'LoginMiddleware', 'PermissionsMiddleware'], 'prefix' => 'self-service', 'namespace' => 'Modules\SelfServiceModule\Http\Controllers'], function () {

    Route::get('/', function () {
        return redirect()->route('module.self-service.feed');
    })->name('module.self-service.home');


    Route::get('/feed', 'UserProfileController@feed')->name('module.self-service.feed');
    Route::get('/all-feeds', 'UserProfileController@getAllFeeds')->name('module.self-service.all-feeds');
    Route::get('/all-trainings', 'UserProfileController@getAllTrainings')->name('module.self-service.all-trainings');
    Route::get('/feed-personal', 'UserProfileController@getPersonalFeeds')->name('module.self-service.feed-personal');
    Route::get('/feed-department', 'UserProfileController@getDepartmentFeeds')->name('module.self-service.feed-department');

    Route::get('/feed/create', 'UserProfileController@createFeed')->name('module.self-service.feed-create');
    Route::post('/storeFeed', 'UserProfileController@storeFeed')->name('module.self-service.feed-store');
    Route::get('/feed/download', 'UserProfileController@downloadFile')->name('module.self-service.feed-download');


    Route::get('/profile', 'UserProfileController@profile')->name('module.self-service.profile');
    Route::put('/profile/update/{id}', 'UserProfileController@profileUpdate')->name('module.self-service.profile-update');


    Route::get('/requests', 'UserProfileController@requests')->name('module.self-service.requests');
    Route::post('/requests/store', 'UserProfileController@createRequest')->name('module.self-service.requests-store');


});

// requests
Route::group(['middleware' => ['web', 'revalidate', 'LoginMiddleware', 'PermissionsMiddleware'], 'prefix' => 'requests', 'namespace' => 'Modules\SelfServiceModule\Http\Controllers'], function () {
    Route::get('/', 'SelfServiceModuleController@index')->name('module.requests.home');
    Route::post('edit', 'SelfServiceModuleController@edit')->name('module.requests.edit');
    Route::post('update', 'SelfServiceModuleController@update')->name('module.requests.update');
    Route::post('manual-request', 'SelfServiceModuleController@manual_request')->name('module.requests.manual-request');
    Route::get('/history', 'SelfServiceModuleController@history')->name('module.requests.history');
    Route::post('/delete-request/{id?}', 'SelfServiceModuleController@delete_request')->name('module.requests.delete-request');
    Route::get('/history-request/edit/{id?}', 'SelfServiceModuleController@edit_request')->name('module.requests.history-edit');
    Route::post('/history-request/update', 'SelfServiceModuleController@update_request')->name('module.requests.history-update');
    Route::get('/load-table', 'SelfServiceModuleController@loadTables')->name('module.requests.history-table-load');
});
