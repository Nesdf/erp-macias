<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcatalogos', 'namespace' => 'Modules\MgCatalogos\Http\Controllers'], function()
{
    Route::get('/', 'MgCatalogosController@index');
    Route::get('/tipo-error', 'TipoErrorController@index')->name('tipo_error');
    Route::post('/create-tipo-error', 'TipoErrorController@create')->name('create_tipo_error');
    Route::post('/update-tipo-error', 'TipoErrorController@update')->name('update_tipo_error');
    Route::get('/departamento-responsable', 'DepartamentoResponsableController@index')->name('departamento_responsable');
    Route::post('/create-departamento-responsable', 'DepartamentoResponsableController@create')->name('create_departamento_responsable');
    Route::post('/update-departamento-responsable', 'DepartamentoResponsableController@update')->name('update_departamento_responsable');
    
    //Rutas para el catálogo de configuración
    Route::get('/configuracion', 'CatalogoConfiguracionesController@index')->name('catalogo_configuracion');
    Route::post('/create-configuracion', 'CatalogoConfiguracionesController@create')->name('create_configuracion');
    Route::post('/update-configuracion', 'CatalogoConfiguracionesController@update')->name('update_configuracion');

});
