<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgproyectos', 'namespace' => 'Modules\MgProyectos\Http\Controllers'], function()
{
    Route::get('/', 'MgProyectosController@index')->name('mgproyectos');//Cargar el listado
	Route::post('/save_proyecto', 'MgProyectosController@store')->name('add_proyecto');//Crear 
	Route::get('/form_delete/{id}', 'MgProyectosController@destroy')->name('delete_proyecto');//Eliminar
	Route::get('/edit_proyecto/{id}', 'MgProyectosController@edit')->name('edit_proyecto');//Editar
	Route::post('/update_proyecto', 'MgProyectosController@update')->name('update_proyecto');//Update
});
