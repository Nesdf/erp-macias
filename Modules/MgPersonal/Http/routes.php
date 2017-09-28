<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgpersonal', 'namespace' => 'Modules\MgPersonal\Http\Controllers'], function()
{
    Route::get('/', 'MgPersonalController@index')->name('mgpersonal');//Cargar el listado
    Route::get('/permisos/{id}', 'MgPersonalController@permisos')->name('permisos_acceso');//Cargar el listado
    Route::post('/save-permisos', 'MgPersonalController@savePermisos')->name('add_permisos');//Cargar el listado
	Route::post('/save-persona', 'MgPersonalController@store')->name('add_personal');//Crear 
	Route::get('/form_delete/{id}', 'MgPersonalController@destroy')->name('delete_personal');//Eliminar
	Route::get('/edit_personal/{id}', 'MgPersonalController@edit')->name('edit_personal');//Editar
	Route::post('/update_persona', 'MgPersonalController@update')->name('update_personal');//Update
});
