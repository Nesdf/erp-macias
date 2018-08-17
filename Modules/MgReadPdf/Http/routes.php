<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgreadpdf', 'namespace' => 'Modules\MgReadPdf\Http\Controllers'], function()
{
    Route::get('/', 'MgReadPdfController@index')->name('pdf');
    Route::post('/save-pdf-actores', 'MgReadPdfController@pdfActores')->name('save_pdf_actores');
    Route::get('/get-episodios-personajes/{id}', 'MgReadPdfController@getEpisodiosPersonajes')->name('get_episodios_personajes');
});