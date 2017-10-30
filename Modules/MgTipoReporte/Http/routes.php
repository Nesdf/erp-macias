<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgtiporeporte', 'namespace' => 'Modules\MgTipoReporte\Http\Controllers'], function()
{
    Route::get('/', 'MgTipoReporteController@index')->name('mgtiporeporte');
    Route::post('/create_reporte', 'MgTipoReporteController@store')->name('add_reporte');
    Route::get('/form_delete/{id}', 'MgTipoReporteController@destroy')->name('delete_reporte');
    Route::get('/edit_reporte/{id}', 'MgTipoReporteController@edit')->name('edit_reporte');
    Route::post('/update_reporte', 'MgTipoReporteController@update')->name('update_reporte');
});
