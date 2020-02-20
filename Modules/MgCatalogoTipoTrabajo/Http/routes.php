<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcatalogotipotrabajo', 'namespace' => 'Modules\MgCatalogoTipoTrabajo\Http\Controllers'], function()
{
    Route::get('/', 'MgCatalogoTipoTrabajoController@index')->name('mgcatalogotipotrabajo');
    Route::get('/edit', 'MgCatalogoTipoTrabajoController@edit')->name('edit_tipo_trabajo');
    Route::post('/create', 'MgCatalogoTipoTrabajoController@create')->name('create_tipo_trabajo');
    Route::post('/update', 'MgCatalogoTipoTrabajoController@update')->name('update_tipo_trabajo');
});
