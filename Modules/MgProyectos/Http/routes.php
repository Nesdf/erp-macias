<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'mgproyectos', 'namespace' => 'Modules\MgProyectos\Http\Controllers'], function()
{
    Route::get('/', 'MgProyectosController@index');//Cargar el listado
	Route::post('/save_proyecto', 'MgProyectosController@store');//Crear 
	Route::get('/form_delete/{id}', 'MgProyectosController@destroy');//Eliminar
	Route::get('/edit_proyecto/{id}', 'MgProyectosController@edit');//Editar
	Route::post('/update_proyecto', 'MgProyectosController@update');//Update
});
