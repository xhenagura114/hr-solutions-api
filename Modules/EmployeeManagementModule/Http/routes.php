<?php

Route::group(['middleware' => ['web','revalidate' , 'LoginMiddleware','PermissionsMiddleware'], 'namespace' => 'Modules\EmployeeManagementModule\Http\Controllers'], function()
{


    Route::resource('employee', 'EmployeeManagementModuleController', ['as' => 'module', 'except' => ['edit', 'update', 'destroy']])->parameters([
        "employee" => "id?"
    ]);

    Route::get('employee-sisal', 'EmployeeManagementModuleController@sisal')->name('module.employee.sisal');

    Route::get('/search-results', ['uses' => 'EmployeeManagementModuleController@search'])->name('module.employee.search-employee');

    Route::resource('applicants', 'ApplicantsController', ['as' => 'module', 'except' => ['create', 'show', 'update']]);

    Route::post('applicants/update/{id}', 'ApplicantsController@update')->name("module.applicants.update");

    Route::get('applicants/approve/{id}', 'ApplicantsController@approve')->name("module.applicants.approve");

    Route::get('applicants/transferSkills', 'ApplicantsController@transferSkills')->name("module.applicants.transferSkills");

    Route::get('applicants/load-table', 'ApplicantsController@loadTable')->name("module.applicants.load-table");

    Route::resource('interviews', 'InterviewsController', ['as' => 'module', 'except' => ['create', 'show', 'update', 'dev']]);

    Route::post('interviews/update/{id}', 'InterviewsController@update')->name("module.interviews.update");

    Route::get('interviews/dev/{id}', 'InterviewsController@dev')->name("module.interviews.dev");

    Route::get('interviews/devOps/{id}', 'InterviewsController@devOps')->name("module.interviews.devOps");

    Route::get('interviews/estimation/{id}', 'InterviewsController@estimation')->name("module.interviews.estimation");

    Route::get('interviews/load-table', 'InterviewsController@loadTable')->name("module.interviews.load-table");

    Route::resource('pre-hired', 'PreHiredController', ['as' => 'module', 'except' => ['create', 'show', 'update']]);

    Route::get('pre-hired/approve/{id}', 'PreHiredController@approve')->name("module.pre-hired.approve");

    Route::get('pre-hired/load-table', 'PreHiredController@loadTable')->name("module.pre-hired.load-table");

    Route::get('interviews/doc', 'InterviewsController@doc')->name("module.interviews.doc");

    Route::resource('internship', 'InternshipController', ['as' => 'module', 'except' => ['create', 'show', 'update']]);

    Route::get('internship/load-table', 'InternshipController@loadTable')->name("module.internship.load-table");

    Route::post('internship/update/{id}', 'InternshipController@update')->name("module.internship.update");

    Route::get('internship/approve/{id}', 'InternshipController@approve')->name("module.internship.approve");

    Route::resource('partners', 'PartnersController', ['as' => 'module', 'except' => ['create', 'show', 'update']]);

    Route::get('partners/load-table', 'PartnersController@loadTable')->name("module.partners.load-table");

    Route::post('partners/update/{id}', 'PartnersController@update')->name("module.partners.update");

    Route::resource('employee-history', 'EmployeeHistoryController', ['as' => 'module', 'except' => ['destroy', 'show', 'edit', 'update', 'store', 'create' ]]);

    Route::resource('statistics', 'StatisticController', ['as' => 'module', 'except' => ['destroy', 'show', 'edit', 'update', 'store', 'create' ]]);

    Route::delete("user/delete/{id?}", ['uses' => 'EmployeeHistoryController@destroy', 'as' => 'module.employee-history.destroy']);

    Route::put("user/restore/{id?}", ['uses' => 'EmployeeHistoryController@restore', 'as' => 'module.employee-history.restore']);

    Route::get('edit/{id?}', ['prefix' => 'employee', 'uses' => 'EmployeeManagementModuleController@edit'])->name('module.employee.edit');

    Route::get('editproject/{id?}', 'EmployeeManagementModuleController@editProject')->name('module.employee.editProject');

    Route::post('searchproject/{id?}', 'EmployeeManagementModuleController@searchProject')->name('module.employee.searchProject');

    Route::post('update/{id}', 'EmployeeManagementModuleController@update')->name("module.employee.update");

    Route::get('google-line-chart/{id}', 'EmployeeManagementModuleController@googleLineChart')->name("module.employee.googleLineChart");

    Route::post('updateProject/{id}', 'EmployeeManagementModuleController@updateProject')->name("module.employee.updateProject");

    Route::delete("delete/{id?}", 'EmployeeManagementModuleController@destroy')->name('module.employee.destroy');

    Route::delete("deleteproject/{id?}", 'EmployeeManagementModuleController@destroyProject')->name('module.employee.destroyProject');

    Route::delete("delete/document/{id?}", ['prefix' => 'employee', 'uses' => 'EmployeeManagementModuleController@destroyDocument'])->name('module.employee.destroy-document');

    Route::get("download/user/{id}", 'EmployeeManagementModuleController@downloadUserDetails')->name('module.employee.download-user-details');

    Route::get('department/requests/{id?}', 'StatisticController@getUsersRequestsByDepartment')->name("module.statistics.get-departments-requests");

    Route::get('holidays-birthdays', 'StatisticController@getBirthdayHoliday')->name("module.statistics.birthday-holiday");

    Route::get('skills', 'SkillsController@index')->name('module.skills.index');

    Route::post('skills', 'SkillsController@searchBySkill')->name('module.skills.search');

});
