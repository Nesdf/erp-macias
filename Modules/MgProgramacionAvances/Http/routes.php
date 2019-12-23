<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgprogramacionavances', 'namespace' => 'Modules\MgProgramacionAvances\Http\Controllers'], function()
{
    Route::get('/', 'MgProgramacionAvancesController@index');
});
