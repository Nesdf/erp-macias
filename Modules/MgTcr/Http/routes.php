<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgtcr', 'namespace' => 'Modules\MgTcr\Http\Controllers'], function()
{
    Route::get('/', 'MgTcrController@index')->name('mgtcr');
    Route::get('/edit/{id}', 'MgTcrController@edit')->name('edit_tcr');
    Route::get('/delete/{id}', 'MgTcrController@destroy')->name('delete_tcr');
    Route::post('/create', 'MgTcrController@store')->name('add_tcr');
    Route::put('/update', 'MgTcrController@update')->name('update_tcr');
});
