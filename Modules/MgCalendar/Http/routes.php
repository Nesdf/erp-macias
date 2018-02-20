<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgcalendar', 'namespace' => 'Modules\MgCalendar\Http\Controllers'], function()
{
    Route::get('/', 'MgCalendarController@index')->name('mgcalendar');
    Route::get('/list_salas/{id}/{id_episodio}', 'MgCalendarController@listSalas')->name('llamados_salas');
    Route::get('/list_episodios/{id}', 'MgCalendarController@listEpisodios')->name('llamado_episodios');
  	Route::get('/calendar_sala/{id}', 'MgCalendarController@calendarSalas')->name('llamado_salas');
  	Route::post('cita-llamado', 'MgCalendarController@citaLlamado')->name('llamado');
    //Route::get('/reagendar-llamado', 'MgCalendarController@citaLlamado')->name('reagendar_llamado');


  	Route::get('/list-llamados', 'MgCalendarController@listLlamados')->name('list_llamado');
  	Route::post('/search-llamados', 'MgCalendarController@searchLlamados')->name('search_llamado');
  	Route::post('/pdf-llamados', 'MgCalendarController@pdfLlamados')->name('pdf_llamado');
  	Route::get('/credenciales-actores/{id}', 'MgCalendarController@credencialesActores')->name('credenciales_actores');
    Route::get('/edit-llamado/{id}', 'MgCalendarController@editllamado')->name('edit_llamado');
    Route::get('/delete_llamado/{id}', 'MgCalendarController@deleteLlamado')->name('delete_llamado');

    Route::post('llamado-actor', 'MgCalendarController@LlamadoActor')->name('llamado_actor');
    Route::get('reagendar-llamado', 'MgCalendarController@reagendarLlamado')->name('reagendar_llamado');
    Route::get('ajax-get-personajes', 'MgCalendarController@ajaxGetPersonajes')->name('ajax_get_personajes');
    Route::post('search-llamado-reagendado', 'MgCalendarController@searchReagendarLlamado')->name('search_llamado_reagendado');
    Route::post('save-llamado-reagendado', 'MgCalendarController@saveReagendarLlamado')->name('save_llamado_reagendado');
});


/*Route::group(['middleware' => ['web', 'auth'], 'prefix' => 'mgcalendar', 'namespace' => 'Modules\MgCalendar\Http\Controllers'], function()
{
    Route::post('llamado-actor', 'MgCalendarController@LlamadoActor')->name('llamado_actor');
    Route::get('reagendar-llamado', 'MgCalendarController@reagendarLlamado')->name('reagendar_llamado');
    Route::get('ajax-get-personajes', 'MgCalendarController@ajaxGetPersonajes')->name('ajax_get_personajes');
    Route::post('search-llamado-reagendado', 'MgCalendarController@searchReagendarLlamado')->name('search_llamado_reagendado');
    Route::post('save-llamado-reagendado', 'MgCalendarController@saveReagendarLlamado')->name('save_llamado_reagendado');
});*/
