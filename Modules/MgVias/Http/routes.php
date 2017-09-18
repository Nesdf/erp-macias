<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgvias', 'namespace' => 'Modules\MgVias\Http\Controllers'], function()
{
    Route::get('/', 'MgViasController@index');//Cargar el listado
	Route::post('/create_via', 'MgViasController@store');//Crear 
	Route::get('/form_delete/{id}', 'MgviasController@destroy');//Eliminar
	Route::get('/edit_via/{id}', 'MgviasController@edit');//Editar
	Route::post('/update_via', 'MgviasController@update');//Update
});
