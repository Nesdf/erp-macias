<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcontabilidad', 'namespace' => 'Modules\MgContabilidad\Http\Controllers'], function()
{
    //Route::get('/', 'MgContabilidadController@index');
    Route::get('reporte-general', 'MgContabilidadController@reporteGeneral')->name('reporte_general');
    Route::get('reporte-llamado-actores', 'MgContabilidadController@reporteLlamadoActores')->name('reporte_llamado_actores');
    Route::get('reporte-actores-sala', 'MgContabilidadController@reporteActoresSala')->name('reporte_actores_sala');
    Route::get('reporte-proyecto', 'MgContabilidadController@reporteProyecto')->name('reporte_proyecto');
    Route::get('reporte-episodio', 'MgContabilidadController@reporteEpisodio')->name('reporte_episodio');
});
