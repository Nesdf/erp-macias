<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgtcr', 'namespace' => 'Modules\MgTcr\Http\Controllers'], function()
{
    Route::get('/', 'MgTcrController@index');
    Route::get('/edit/{id}', 'MgTcrController@edit');
    Route::get('/delete/{id}', 'MgTcrController@destroy');
    Route::post('/create', 'MgTcrController@store');
    Route::put('/update', 'MgTcrController@update');
});
