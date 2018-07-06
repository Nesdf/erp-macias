<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgreadpdf', 'namespace' => 'Modules\MgReadPdf\Http\Controllers'], function()
{
    Route::get('/', 'MgReadPdfController@index');
});
