<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgdestino', 'namespace' => 'Modules\MgDestino\Http\Controllers'], function()
{
    Route::get('/', 'MgDestinoController@index')->name('destino');
    Route::post('/nuevo-destino', 'MgDestinoController@nuevoDestino')->name('nuevo-destino');
    Route::post('/update-destino', 'MgDestinoController@updateDestino')->name('update-destino');
    Route::post('/show-destino', 'MgDestinoController@show')->name('show-destino');
});
