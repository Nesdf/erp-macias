<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgmetodoenvio', 'namespace' => 'Modules\MgMetodoEnvio\Http\Controllers'], function()
{
    Route::get('/', 'MgMetodoEnvioController@index')->name('metodo-envio');

    Route::post('/crear-metodo-envio', 'MgMetodoEnvioController@createMetodoEnvio')->name('crear-metodo-envio');
    Route::post('/update-metodo-envio', 'MgMetodoEnvioController@updateMetodoEnvio')->name('update-metodo-envio');
    Route::post('/show-metodo-envio', 'MgMetodoEnvioController@show')->name('show-metodo-envio');
});
