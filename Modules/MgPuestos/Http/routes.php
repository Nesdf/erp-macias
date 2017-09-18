<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgpuestos', 'namespace' => 'Modules\MgPuestos\Http\Controllers'], function()
{
    Route::get('/', 'MgPuestosController@index');//Cargar el listado
	Route::post('/create_puesto', 'MgPuestosController@store');//Crear 
	Route::get('/form_delete/{id}', 'MgPuestosController@destroy');//Eliminar
	Route::get('/edit_puesto/{id}', 'MgPuestosController@edit');//Editar
	Route::post('/update_puesto', 'MgPuestosController@update');//Update
});
