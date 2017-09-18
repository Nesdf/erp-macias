<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgclientes', 'namespace' => 'Modules\MgClientes\Http\Controllers'], function()
{
    Route::get('/', 'MgClientesController@index');//Cargar el listado
	Route::post('/save_cliente', 'MgClientesController@store');//Crear 
	Route::get('/form_delete/{id}', 'MgClientesController@destroy');//Eliminar
	Route::get('/edit_clientes/{id}', 'MgClientesController@edit');//Editar
	Route::post('/update_clientes', 'MgClientesController@update');//Update
	Route::get('/list_countries/{id}', 'MgClientesController@list_countries');//Lista de Ciudades
});
