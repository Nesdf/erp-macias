<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcatalogos', 'namespace' => 'Modules\MgCatalogos\Http\Controllers'], function()
{
    Route::get('/', 'MgCatalogosController@index');
    Route::get('/tipo-error', 'TipoErrorController@index')->name('tipo-error');
    Route::post('/create-tipo-error', 'TipoErrorController@create')->name('create-tipo-error');
    Route::post('/update-tipo-error', 'TipoErrorController@update')->name('update-tipo-error');
    Route::get('/departamento-responsable', 'DepartamentoResponsableController@index')->name('departamento-responsable');
    Route::post('/create-departamento-responsable', 'DepartamentoResponsableController@create')->name('create-departamento-responsable');
    Route::post('/update-departamento-responsable', 'DepartamentoResponsableController@update')->name('update-departamento-responsable');
    
    //Rutas para el catálogo de configuración
    Route::get('/configuracion', 'CatalogoConfiguracionesController@index')->name('catalogo-configuracion');
    Route::post('/create-configuracion', 'CatalogoConfiguracionesController@create')->name('create-configuracion');
    Route::post('/update-configuracion', 'CatalogoConfiguracionesController@update')->name('update-configuracion');

});
