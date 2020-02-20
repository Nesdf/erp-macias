<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgmetodoenvio', 'namespace' => 'Modules\MgMetodoEnvio\Http\Controllers'], function()
{
    Route::get('/', 'MgMetodoEnvioController@index')->name('mgmetodoenvio');

    Route::post('/crear-metodo-envio', 'MgMetodoEnvioController@createMetodoEnvio')->name('crear_metodo_envio');
    Route::post('/update-metodo-envio', 'MgMetodoEnvioController@updateMetodoEnvio')->name('update_metodo_envio');
    Route::post('/show-metodo-envio', 'MgMetodoEnvioController@show')->name('show_metodo_envio');
});
