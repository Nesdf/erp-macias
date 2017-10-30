<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgactores', 'namespace' => 'Modules\MgActores\Http\Controllers'], function()
{
    Route::get('/', 'MgActoresController@index');
    Route::post('/save_actor', 'MgActoresController@store')->name('save_actor');
    Route::get('/edit_actor/{id}', 'MgActoresController@edit')->name('edit_actor');//Editar
    Route::post('/update_actor', 'MgActoresController@update')->name('update_actor');//Actualizar
    Route::get('/delete_actor/{id}', 'MgActoresController@destroy')->name('delete_actor');//Actualizar
});
