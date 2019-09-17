<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgreadpdf', 'namespace' => 'Modules\MgReadPdf\Http\Controllers'], function()
{
    Route::get('/', 'MgReadPdfController@index')->name('pdf');
    Route::post('/save-pdf-actores', 'MgReadPdfController@pdfActores')->name('save_pdf_actores');
    Route::get('/get-episodios-personajes/{id}', 'MgReadPdfController@getEpisodiosPersonajes')->name('get_episodios_personajes');
    Route::get('/modificar-personajes', 'MgReadPdfController@create')->name('modificar_personajes');
    Route::get('/lista-perosnajes/{folio}', 'MgReadPdfController@listaPersonajes')->name('lista-perosnajes');
    Route::post('/update-personaje', 'MgReadPdfController@updatePersonaje')->name('update-personaje');
});

