<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgprogramacionavances', 'namespace' => 'Modules\MgProgramacionAvances\Http\Controllers'], function()
{
    Route::get('/', 'MgProgramacionAvancesController@index')->name('mgprogramacionavances');
});
