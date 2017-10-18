<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgcalendar', 'namespace' => 'Modules\MgCalendar\Http\Controllers'], function()
{
    Route::get('/', 'MgCalendarController@index');
});
