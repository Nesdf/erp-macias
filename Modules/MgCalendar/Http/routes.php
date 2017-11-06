<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcalendar', 'namespace' => 'Modules\MgCalendar\Http\Controllers'], function()
{
    Route::get('/', 'MgCalendarController@index')->name('list_llamados');
    Route::get('/list_salas/{id}/{id_episodio}', 'MgCalendarController@listSalas')->name('llamados_salas');
    Route::get('/list_episodios/{id}', 'MgCalendarController@listEpisodios')->name('llamado_episodios');
	Route::get('/calendar_sala/{id}', 'MgCalendarController@calendarSalas')->name('llamado_salas');
	Route::post('/cita-llamado', 'MgCalendarController@citaLlamado')->name('llamado');
	Route::get('/list-llamados', 'MgCalendarController@listLlamados')->name('list-llamado');
	Route::post('/search-llamados', 'MgCalendarController@searchLlamados')->name('search-llamado');
	Route::post('/pdf-llamados', 'MgCalendarController@pdfLlamados')->name('pdf-llamado');
	Route::get('/credenciales-actores/{id}', 'MgCalendarController@credencialesActores')->name('credenciales-actores');
    Route::get('/edit-llamado/{id}', 'MgCalendarController@editllamado')->name('edit-llamado');
    Route::get('/delete_llamado/{id}', 'MgCalendarController@deleteLlamado')->name('delete-llamado');
});
