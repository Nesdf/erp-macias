<?php

Route::group(['middleware' => ['web', 'auth', 'verify_routes'], 'prefix' => 'mgtraductores', 'namespace' => 'Modules\MgTraductores\Http\Controllers'], function()
{
    Route::get('/{id}', 'MgTraductoresController@index');
});
