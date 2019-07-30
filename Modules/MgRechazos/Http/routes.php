<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgrechazos', 'namespace' => 'Modules\MgRechazos\Http\Controllers'], function()
{
    Route::get('/', 'MgRechazosController@index')->name('rechazos');
    Route::post('/modal-rechazos', 'MgRechazosController@modalRechazos')->name('modal-rechazos');
    Route::post('/create', 'MgRechazosController@create')->name('create-rechazos');
    Route::post('/update', 'MgRechazosController@update')->name('update-rechazos');
    Route::post('/rechazos-select-proyectos', 'MgRechazosController@rechazosSelectProyectos')->name('rechazos-select-proyectos');
    Route::post('/rechazos-select-temporada', 'MgRechazosController@rechazosSelectTemporada')->name('rechazos-select-temporada');
    Route::post('/rechazos-select-proyectos-id', 'MgRechazosController@rechazosSelectProyectosId')->name('rechazos-select-proyectos-id');
});
