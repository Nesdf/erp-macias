<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgtrafico', 'namespace' => 'Modules\MgTrafico\Http\Controllers'], function()
{
    Route::get('/', 'MgTraficoController@index')->name('mgtrafico');

    Route::post('/fecha-embarque-update', 'MgTraficoController@fechaEmbarqueUpdate')->name('fecha_embarque_update');
});
