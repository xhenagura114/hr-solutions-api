<?php

Route::group(['middleware' => ['web', 'revalidate', 'LoginMiddleware','PermissionsMiddleware'], 'prefix' => 'calendar', 'namespace' => 'Modules\CalendarModule\Http\Controllers'], function () {

    Route::get('/', 'CalendarModuleController@index')->name('module.calendar.home');
    Route::post('create-event', 'CalendarModuleController@create')->name('module.calendar.create-event');
    Route::post('delete-event', 'CalendarModuleController@destroy')->name('module.calendar.delete-event');

    Route::post('create-event-type', 'CalendarModuleController@createType')->name('module.calendar.create-type');
    Route::post('edit-event-type', 'CalendarModuleController@editType')->name('module.calendar.edit-type');
    Route::post('delete-event-type', 'CalendarModuleController@deleteType')->name('module.calendar.delete-type');
    Route::post('event-modal', 'CalendarModuleController@event_modal')->name('module.calendar.event-modal');

});
