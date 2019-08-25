<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgentregables', 'namespace' => 'Modules\MgEntregables\Http\Controllers'], function()
{
    Route::get('/', 'MgEntregablesController@index')->name('entregables');
    Route::post('/nuevo-entregable', 'MgEntregablesController@nuevoEntregable')->name('nuevo-entregable');
    Route::post('/update-entregable', 'MgEntregablesController@updateEntregable')->name('update-entregable');
    Route::post('/show-entregable', 'MgEntregablesController@show')->name('show-entregable');
});
