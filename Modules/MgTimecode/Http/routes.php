<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgtimecode', 'namespace' => 'Modules\MgTimecode\Http\Controllers'], function()
{
    Route::get('/', 'MgTimecodeController@index');
	Route::post('/create_tc', 'MgTimecodeController@store')->name('add_tc');//Crear 
	Route::get('/form_delete/{id}', 'MgTimecodeController@destroy')->name('delete_tc');//Eliminar
	Route::get('/edit_tc/{id}', 'MgTimecodeController@edit')->name('edit_tc');//Editar
	Route::post('/update_tc', 'MgTimecodeController@update')->name('update_tc');//Update
});
