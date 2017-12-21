<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgproyectosproductor', 'namespace' => 'Modules\MgProyectosProductor\Http\Controllers'], function()
{
    Route::get('/', 'MgProyectosProductorController@index');
});
