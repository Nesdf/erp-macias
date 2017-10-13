<?php

Route::group(['middleware' => 'web', 'prefix' => 'mgtraductores', 'namespace' => 'Modules\MgTraductores\Http\Controllers'], function()
{
    Route::get('/{id}', 'MgTraductoresController@index');
});
