<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgsucursales', 'namespace' => 'Modules\MgSucursales\Http\Controllers'], function()
{
    Route::get('/', 'MgSucursalesController@index')->name('mgsucursales');
    Route::post('/save_sucursal', 'MgSucursalesController@store')->name('add_sucursal');//Crear 
    Route::post('/add_ciudad', 'MgSucursalesController@storeCiudad')->name('add_ciudad');//Crear 
	Route::get('/delete_ciudad/{id}', 'MgSucursalesController@destroyCiudad')->name('delete_ciudad');
});
