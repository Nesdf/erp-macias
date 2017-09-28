<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgclientes', 'namespace' => 'Modules\MgClientes\Http\Controllers'], function()
{
    Route::get('/', 'MgClientesController@index')->name('mgclientes');//Cargar el listado
	Route::post('/save_cliente', 'MgClientesController@store')->name('add_cliente');//Crear 
	Route::get('/form_delete/{id}', 'MgClientesController@destroy')->name('delete_cliente');//Eliminar
	Route::get('/edit_clientes/{id}', 'MgClientesController@edit')->name('edit_cliente');//Editar
	Route::post('/update_clientes', 'MgClientesController@update')->name('update_cliente');//Update
	Route::get('/list_countries/{id}', 'MgClientesController@list_countries')->name('list_countries');//Lista de Ciudades
});
