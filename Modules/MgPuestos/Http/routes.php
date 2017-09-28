<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgpuestos', 'namespace' => 'Modules\MgPuestos\Http\Controllers'], function()
{
    Route::get('/', 'MgPuestosController@index')->name('mgpuestos');//Cargar el listado
	Route::post('/create_puesto', 'MgPuestosController@store')->name('add_puesto');//Crear 
	Route::get('/form_delete/{id}', 'MgPuestosController@destroy')->name('delete_puesto');//Eliminar
	Route::get('/edit_puesto/{id}', 'MgPuestosController@edit')->name('edit_puesto');//Editar
	Route::post('/update_puesto', 'MgPuestosController@update')->name('update_puesto');//Update
});
