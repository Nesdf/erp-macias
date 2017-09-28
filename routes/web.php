<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function(){
	Route::get('/home', 'BackendController@index');
	Route::get('/salir', function(){
		\Auth::logout();
		return redirect('login');
	});
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', function(){
	return redirect('login');
});

Route::get('/email', 'HomeController@sendEmail');
