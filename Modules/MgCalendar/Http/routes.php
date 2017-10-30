<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcalendar', 'namespace' => 'Modules\MgCalendar\Http\Controllers'], function()
{
    Route::get('/', 'MgCalendarController@index');
    Route::get('/list_salas/{id}', 'MgCalendarController@listSalas');
    Route::get('/list_episodios/{id}', 'MgCalendarController@listEpisodios');
	Route::get('/calendar_sala/{id}', 'MgCalendarController@calendarSalas');
	Route::post('/cita-llamado', 'MgCalendarController@citaLlamado');
    
});
