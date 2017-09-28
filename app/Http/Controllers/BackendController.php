<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackendController extends Controller
{
    //
	
	public function index()
	{
		//Permite mostrar el menú en toda la aplicci´ón
		$urls = \Modules\MgPersonal\Entities\RoutesAccess::where('user_id', \Auth::user()->id)->get();
    	
    	foreach ($urls as $value) {
    		\Session::put($value->alias_name, $value->alias_name);
    	}

		//Permite mostrar nombre y puesto en toda la aplicación
		$job = \App\Jobs::where('id', \Auth::user()->job)->get();
		\Session::forget('admin_puesto');
		\Session::put('admin_puesto', $job[0]->job);
		return view('backend.index');
	}
	
	public function salir()
	{
		Auth::logout();
		return redirect('/');
	}
}
