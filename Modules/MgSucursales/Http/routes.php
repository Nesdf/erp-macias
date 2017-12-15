<?php

Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'mgsucursales', 'namespace' => 'Modules\MgSucursales\Http\Controllers'], function()
{
    Route::get('/', 'MgSucursalesController@index')->name('mgsucursales');
    Route::post('/save_sucursal', 'MgSucursalesController@store')->name('add_sucursal');//Crear  Pais
    Route::post('/edit_sucursal', 'MgSucursalesController@edit')->name('edit_sucursal');//Editar Pais
    Route::get('/delete_pais/{id}', 'MgSucursalesController@destroy')->name('delete_pais'); //Eliminar país
    Route::post('/add_ciudad', 'MgSucursalesController@storeCiudad')->name('add_ciudad');//Crear  Estado
    Route::post('/edit_ciudad', 'MgSucursalesController@editEstado')->name('edit_ciudad');//Editar Estado
	Route::get('/delete_ciudad/{id}', 'MgSucursalesController@destroyCiudad')->name('delete_ciudad');
});
#, 'verify_routes'