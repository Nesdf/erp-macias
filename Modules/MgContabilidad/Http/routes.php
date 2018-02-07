<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcontabilidad', 'namespace' => 'Modules\MgContabilidad\Http\Controllers'], function()
{
    //Route::get('/', 'MgContabilidadController@index');
    Route::get('reporte-general', 'MgContabilidadController@reporteGeneral')->name('reporte_general');
    Route::post('ajax_reporte-general', 'MgContabilidadController@ajaxReporteGeneral')->name('ajax_reporte_general');
    Route::get('reporte-llamado-actores', 'MgContabilidadController@reporteLlamadoActores')->name('reporte_llamado_actores');
    Route::post('ajax-llamado-actores', 'MgContabilidadController@ajaxLlamadoActores')->name('ajax_llamado_actores');
    Route::get('reporte-nomina-actores', 'MgContabilidadController@reporteNominaActores')->name('reporte_nomina-actores');
    Route::post('ajax-nomina-actores', 'MgContabilidadController@ajaxNominaActores')->name('ajax_nomina-actores');
    Route::get('reporte-proyectos', 'MgContabilidadController@reporteProyectos')->name('reporte_proyecto');
    Route::post('ajax-reporte-proyectos', 'MgContabilidadController@ajaxReporteProyectos')->name('ajax_reporte_proyecto');
    Route::get('detalle-episodios-actores/{folio}/{fecha_inicio}/{fecha_fin}','MgContabilidadController@detalleEpisodiosActores')->name('detalle_episodios_actores');
    Route::get('reporte-episodio', 'MgContabilidadController@reporteEpisodio')->name('reporte_episodio');
    Route::post('ajax_reporte-episodios', 'MgContabilidadController@ajaxReporteEpisodios')->name('ajax_reporte_episodios');
    Route::get('reporte-trabajo-actor', 'MgContabilidadController@reporteTrabajoActor')->name('reporte_trabajo_actor');
});
