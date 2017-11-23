<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgproyectostraductor', 'namespace' => 'Modules\MgProyectosTraductor\Http\Controllers'], function()
{
    Route::get('/', 'MgProyectosTraductorController@index')->name('mgproyectostraductor');
});
