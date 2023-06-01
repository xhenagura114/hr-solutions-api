<?php

Route::group(['middleware' => ['web', 'LoginMiddleware', 'PermissionsMiddleware'], 'prefix' => 'reports', 'namespace' => 'Modules\ReportsModule\Http\Controllers'], function()
{
    Route::get('/', ['uses' => 'ReportsModuleController@index'])->name('module.reports.index');

    Route::get('contracts/{type}', ['uses' => 'ReportsModuleController@contracts'])->name('module.reports.contracts')->where('type', '(year|month)');

    Route::get('terminations', ['uses' => 'ReportsModuleController@terminations'])->name('module.reports.terminations');

    Route::get('leaves', ['uses' => 'ReportsModuleController@leaves'])->name('module.reports.leaves');

    Route::get('trainings', ['uses' => 'ReportsModuleController@trainings'])->name('module.reports.trainings');

    Route::get('interviews', ['uses' => 'ReportsModuleController@interviews'])->name('module.reports.interviews');

    Route::get('applicants', ['uses' => 'ReportsModuleController@applicants'])->name('module.reports.applicants');

    Route::get('partners', ['uses' => 'ReportsModuleController@partners'])->name('module.reports.partners');

    Route::get('skills', ['uses' => 'ReportsModuleController@skills'])->name('module.reports.skills');
});
