<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'mgepisodios', 'namespace' => 'Modules\MgEpisodios\Http\Controllers'], function()
{
    Route::get('/{id}', 'MgEpisodiosController@index');//Cargar el listado
	Route::post('/save', 'MgEpisodiosController@store');//Crear 
	Route::get('/delete/{id}/{id_proyecto}', 'MgEpisodiosController@destroy');//Eliminar
	Route::get('/edit/{id}', 'MgEpisodiosController@edit');//Editar
	Route::post('/update', 'MgEpisodiosController@update');//Update
	Route::get('/show_episodio/{id}', 'MgEpisodiosController@show');//Mostrar


	Route::post('/calificar_material', 'MgCalificarMaterialController@store');
	Route::get('/material-calificado/{id_episodio}/{id_proyecto}', 'MgCalificarMaterialController@materialCalificado');
	Route::post('/update-material-calificado/{id_episodio}/{id_proyecto}', 'MgCalificarMaterialController@update');
	Route::post('/save-timecode', 'MgCalificarMaterialController@saveTimecode');
	Route::get('material-calificado-pdf/{id_episodio}/{id_proyecto}', 'MgCalificarMaterialController@pdf');

});
