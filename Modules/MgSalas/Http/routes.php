<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgsalas', 'namespace' => 'Modules\MgSalas\Http\Controllers'], function()
{
    Route::get('/', 'MgSalasController@index')->name('mgsalas');
    Route::post('/create_sala', 'MgSalasController@store')->name('add_sala');//Crear Sala
	Route::get('/form_delete/{id}', 'MgSalasController@destroy')->name('delete_sala');//Eliminar
	Route::get('/edit_sala/{id}', 'MgSalasController@edit')->name('edit_sala');//Editar
	Route::post('/update_sala', 'MgSalasController@update')->name('update_sala');//Update

	Route::post('/create_estudio', 'MgSalasController@storeEstudio')->name('add_estudio');//Crear Estdio
	Route::post('/edit_estudio', 'MgSalasController@editEstudio')->name('edit_estudio');//Editar Estdio
});
