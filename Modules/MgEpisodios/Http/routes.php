<?php

Route::group(['middleware' => ['web', 'auth','verify_routes'], 'prefix' => 'mgepisodios', 'namespace' => 'Modules\MgEpisodios\Http\Controllers'], function()
{
    Route::get('/{id}', 'MgEpisodiosController@index')->name('mgepisodios');//Cargar el listado
	Route::post('/save', 'MgEpisodiosController@store')->name('add_episodio');//Crear 
	Route::get('/delete/{id}/{id_proyecto}', 'MgEpisodiosController@destroy')->name('delete_episodio');//Eliminar
	Route::get('/edit/{id}', 'MgEpisodiosController@edit')->name('edit_episodio');//Editar
	Route::post('/update', 'MgEpisodiosController@update')->name('update_episodio');//Update
	Route::post('/update-configuracion', 'MgEpisodiosController@updateConfiguration')->name('update_configuracion_episodio');//Update
	Route::get('/show_episodio/{id}', 'MgEpisodiosController@show')->name('show_episodio');//Mostrar
	Route::post('/assign-traductor', 'MgEpisodiosController@assignTraductor')->name('add_asignar_traductor');//Mostrar


	Route::post('/calificar_material', 'MgCalificarMaterialController@store')->name('add_calificar_material');
	Route::get('/material-calificado/{id_episodio}/{id_proyecto}', 'MgCalificarMaterialController@materialCalificado')->name('show_calificar_material');
	Route::post('/update-material-calificado/{id_episodio}/{id_proyecto}', 'MgCalificarMaterialController@update')->name('update_calificar_material');
	Route::post('/save-timecode', 'MgCalificarMaterialController@saveTimecode')->name('add_timecode');
	Route::get('/material-calificado-pdf/{id_episodio}/{id_proyecto}', 'MgCalificarMaterialController@pdf')->name('create_timecode_pdf');

	Route::post('/add-traductor', 'MgEpisodiosController@addTraductor')->name('add_traductor');
	Route::post('/add-productor', 'MgEpisodiosController@addProductor')->name('add_productor');

});
