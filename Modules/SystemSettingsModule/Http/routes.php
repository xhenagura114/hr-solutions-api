<?php

Route::group(['middleware' => ['web', 'revalidate', 'LoginMiddleware', 'PermissionsMiddleware'], 'prefix' => 'system-settings', 'namespace' => 'Modules\SystemSettingsModule\Http\Controllers'], function () {


    Route::get('/', function () {
        return redirect()->route('module.general-settings.index');
    })->name('module.system-settings.home');


    Route::resource('departments', 'DepartmentController', ['as' => 'module', 'except' => ['create', 'show', 'destroy']]);
    //AJAX CALLS FROM DEPARTMENT TREE
    Route::post('new-department', 'DepartmentController@createFromTree')->name('module.departments.new-department');
    Route::post('department-color', 'DepartmentController@changeDepartmentColor')->name('module.departments.department-color');
    Route::post('edit-department', 'DepartmentController@editDepartment')->name('module.departments.edit-department');
    Route::post('delete-department', 'DepartmentController@deleteDepartment')->name('module.departments.delete-department');


    Route::resource('positions', 'PositionController', ['as' => 'module', 'except' => ['create', 'show']]);
    Route::resource('job-vacancies', 'JobVacancyController', ['as' => 'module', 'except' => ['create', 'show']]);
    Route::resource('official-holidays', 'OfficialHolidayController', ['as' => 'module', 'except' => ['create', 'show']])->parameters([
        "official_holiday" => "id?"
    ]);;
    Route::resource('general-settings', 'GeneralSettingsController', ['as' => 'module', 'except' => ['create', 'show', 'edit', 'store', 'destroy']]);
    Route::resource('trainings', 'TrainingController', ['as' => 'module', 'except' => ['create', 'show']]);
    Route::post('dark-mode', 'GeneralSettingsController@dark_mode')->name('module.template.dark-mode');


    Route::get("roles", "RoleController@index")->name('module.roles.index');
    Route::post("role", "RoleController@store")->name('module.roles.store');
    Route::get("role/{id}/edit", "RoleController@edit")->name('module.roles.edit');
    Route::put("role/{id}/update", "RoleController@update")->name('module.roles.update');
    Route::get("permissions/{id}/edit", ["as" => "module.roles.permissions-edit", "action-for" => "user", "uses" => "RoleController@edit"]);
    Route::put("permissions/{id}/update",  ["as"=> "module.roles.permissions-update", "action-for" => "user", "uses" => "RoleController@update"]);

    Route::delete("role/delete/{id?}", "RoleController@destroy")->name('module.roles.destroy');

    Route::put("set-role", "RoleController@setRole")->name('module.roles.set-user-role');

    Route::get('hierarchy', 'GeneralSettingsController@hierarchy')->name('module.template.hierarchy');

    Route::resource('api-urls', 'ApiUrlController', ['as' => 'module']);

    Route::resource('skill-setting', 'SkillsSettingsController', ['as' => 'module']);

});

