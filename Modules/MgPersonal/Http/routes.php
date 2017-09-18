<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'mgpersonal', 'namespace' => 'Modules\MgPersonal\Http\Controllers'], function()
{
    Route::get('/', 'MgPersonalController@index');//Cargar el listado
	Route::post('/save-persona', 'MgPersonalController@store');//Crear 
	Route::get('/form_delete/{id}', 'MgPersonalController@destroy');//Eliminar
	Route::get('/edit_personal/{id}', 'MgPersonalController@edit');//Editar
	Route::post('/update_persona', 'MgPersonalController@update');//Update
});
