<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgtrafico', 'namespace' => 'Modules\MgTrafico\Http\Controllers'], function()
{
    Route::get('/', 'MgTraficoController@index')->name('trafico');

    Route::post('/fecha-embarque-update', 'MgTraficoController@fechaEmbarqueUpdate')->name('fecha-embarque-update');
});
