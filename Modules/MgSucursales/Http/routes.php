<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgsucursales', 'namespace' => 'Modules\MgSucursales\Http\Controllers'], function()
{
    Route::get('/', 'MgSucursalesController@index')->name('mgsucursales');
    Route::post('/save_sucursal', 'MgSucursalesController@store')->name('add_sucursal');//Crear 
	Route::get('/form_delete/{id}', 'MgSucursalesController@destroy')->name('delete_sucursal');//Eliminar
	Route::get('/edit_sucursal/{id}', 'MgSucursalesController@edit')->name('edit_sucursal');//Editar
	Route::post('/update_sucursal', 'MgSucursalesController@update')->name('update_sucursal');//Update
});
