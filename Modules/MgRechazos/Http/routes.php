<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgrechazos', 'namespace' => 'Modules\MgRechazos\Http\Controllers'], function()
{
    Route::get('/', 'MgRechazosController@index');
    Route::post('/create', 'MgRechazosController@create');
    Route::post('/update', 'MgRechazosController@update');
});
