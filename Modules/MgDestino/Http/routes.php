<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgdestino', 'namespace' => 'Modules\MgDestino\Http\Controllers'], function()
{
    Route::get('/', 'MgDestinoController@index')->name('mgdestino');
    Route::post('/nuevo-destino', 'MgDestinoController@nuevoDestino')->name('nuevo_destino');
    Route::post('/update-destino', 'MgDestinoController@updateDestino')->name('update_destino');
    Route::post('/show-destino', 'MgDestinoController@show')->name('show_destino');
});
