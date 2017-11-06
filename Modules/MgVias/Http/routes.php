<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgvias', 'namespace' => 'Modules\MgVias\Http\Controllers'], function()
{
    Route::get('/', 'MgViasController@index')->name('mgvias');//Cargar el listado
	Route::post('/create_via', 'MgViasController@store')->name('add_via');//Crear 
	Route::get('/form_delete/{id}', 'MgViasController@destroy')->name('delete_via');//Eliminar
	Route::get('/edit_via/{id}', 'MgViasController@edit')->name('edit_via');//Editar
	Route::post('/update_via', 'MgViasController@update')->name('update_via');//Update
});
