<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcatalogotipotrabajo', 'namespace' => 'Modules\MgCatalogoTipoTrabajo\Http\Controllers'], function()
{
    Route::get('/', 'MgCatalogoTipoTrabajoController@index')->name('list-tipo-trabajo');
    Route::get('/edit', 'MgCatalogoTipoTrabajoController@edit')->name('edit-tipo-trabajo');
    Route::post('/create', 'MgCatalogoTipoTrabajoController@create')->name('create-tipo-trabajo');
    Route::post('/update', 'MgCatalogoTipoTrabajoController@update')->name('update-tipo-trabajo');
});
