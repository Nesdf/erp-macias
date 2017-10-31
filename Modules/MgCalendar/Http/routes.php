<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcalendar', 'namespace' => 'Modules\MgCalendar\Http\Controllers'], function()
{
    Route::get('/', 'MgCalendarController@index')->name('list_llamados');
    Route::get('/list_salas/{id}', 'MgCalendarController@listSalas')->name('llamados_salas');
    Route::get('/list_episodios/{id}', 'MgCalendarController@listEpisodios')->name('llamado_episodios');
	Route::get('/calendar_sala/{id}', 'MgCalendarController@calendarSalas')->name('llamado_salas');
	Route::post('/cita-llamado', 'MgCalendarController@citaLlamado')->name('llamado');
    
});
