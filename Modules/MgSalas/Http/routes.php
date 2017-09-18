<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgsalas', 'namespace' => 'Modules\MgSalas\Http\Controllers'], function()
{
    Route::get('/', 'MgSalasController@index');
    Route::post('/create_sala', 'MgSalasController@store');//Crear 
	Route::get('/form_delete/{id}', 'MgSalasController@destroy');//Eliminar
	Route::get('/edit_sala/{id}', 'MgSalasController@edit');//Editar
	Route::post('/update_sala', 'MgSalasController@update');//Update
});
