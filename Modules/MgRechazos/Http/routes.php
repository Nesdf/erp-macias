<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgrechazos', 'namespace' => 'Modules\MgRechazos\Http\Controllers'], function()
{
    Route::get('/', 'MgRechazosController@index')->name('mgrechazos');
    Route::post('/create-rechazos', 'MgRechazosController@create')->name('create_rechazos');
    Route::post('/update-rechazos', 'MgRechazosController@update')->name('update_rechazos');
});


Route::group(['middleware' => ['web', 'auth', ], 'prefix' => 'mgrechazos', 'namespace' => 'Modules\MgRechazos\Http\Controllers'], function()
{
    //Route::get('/', 'MgRechazosController@index')->name('rechazos');
    Route::post('/modal-rechazos', 'MgRechazosController@modalRechazos')->name('modal_rechazos');
    // Route::post('/create', 'MgRechazosController@create')->name('create-rechazos');
    // Route::post('/update', 'MgRechazosController@update')->name('update-rechazos');
    Route::post('/rechazos-select-proyectos', 'MgRechazosController@rechazosSelectProyectos')->name('rechazos_select_proyectos');
    Route::post('/rechazos-select-temporada', 'MgRechazosController@rechazosSelectTemporada')->name('rechazos_select_temporada');
    Route::post('/rechazos-select-proyectos-id', 'MgRechazosController@rechazosSelectProyectosId')->name('rechazos_select_proyectos_id');
    //ista-rechazos
    Route::post('/lista-rechazo', 'MgRechazosController@listaRechazos')->name('lista_rechazos');
});
