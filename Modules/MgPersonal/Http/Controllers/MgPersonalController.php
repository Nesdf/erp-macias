<?php

namespace Modules\MgPersonal\Http\Controllers;
# Comentario de prueba

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
class MgPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
		$personas = \Modules\MgPersonal\Entities\User::Personal();
		$puestos = \Modules\MgPersonal\Entities\Jobs::get();
        return view('mgpersonal::index', compact('personas', 'puestos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgpersonal::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		if( $request->method('post') && $request->ajax() ){
			
			$rules = [
				'nombre' => 'required|min:2|max:50',
				'ap_paterno' => 'required|min:2|max:50',
				'correo' => 'required|email',
				'password' => 'required',
				'puesto' => 'required'
				
			];
			
			$messages = [
				'nombre.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'nombre.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'nombre.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'ap_paterno.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'ap_paterno.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'ap_paterno.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'correo.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.correo')]),
				'correo.email' => trans('mgpersonal::ui.display.error_email', ['attribute' => trans('mgpersonal::ui.attribute.correo')]),
				'password.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.password')]),
				'puesto.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.puesto')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {
				\Modules\MgPersonal\Entities\User::create([					
					'ap_paterno' => ucwords( $request->input('ap_paterno') ),
					'ap_materno' => ucwords( $request->input('ap_materno') ),
					'password' => Hash::make( $request->input('password') ),
					'email' => strtolower( $request->input('correo') ),
					'name' => ucwords( $request->input('nombre') ),
					'job' => $request->input('puesto')
				]);
				$request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_personal'));
				return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
			}
		}		
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
       return view('mgpersonal::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {		
		return \Modules\MgPersonal\Entities\User::find($id);       
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
		if( $request->method('post') && $request->ajax() ){

			$rules = [
				'nombre' => 'required|min:2|max:50',
				'ap_paterno' => 'required|min:2|max:50',
				'correo' => 'required|email',
				'puesto' => 'required'
				
			];
			
			$messages = [
				'nombre.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'nombre.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'nombre.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'ap_paterno.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'ap_paterno.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'ap_paterno.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'correo.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.correo')]),
				'correo.email' => trans('mgpersonal::ui.display.error_email', ['attribute' => trans('mgpersonal::ui.attribute.correo')]),
				'puesto.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.puesto')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {

				$data = array(
					'ap_paterno' => ucwords( $request->input('ap_paterno') ),
					'ap_materno' => ucwords( $request->input('ap_materno') ),
					'email' => strtolower( $request->input('correo') ),
					'name' => ucwords( $request->input('nombre') ),
					'job' => $request->input('puesto')
				);

				if( $request->input('password') ){
					$data['password'] = \Hash::make($request->input('password'));
				}

				\Modules\MgPersonal\Entities\User::where('id', $request->input('id'))
				->update( $data );
				$request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_personal'));
				return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
			}
		}		
    }
	
    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
		\Modules\MgPersonal\Entities\User::destroy($id);
		\Request::session()->flash('message', trans('mgpersonal::ui.flash.flash_delete_peronal'));
		return redirect('mgpersonal');
    }

    public function permisos($id)
    {
    	$urls = \Modules\MgPersonal\Entities\RoutesAccess::where('user_id', $id)->get();
    	$urlArray=array();
    	foreach ($urls as $value) {
    		$urlArray[$value->alias_name] = $value->alias_name;
    	}
    	$empleado = \Modules\MgPersonal\Entities\User::Empleado($id);
    	return view('mgpersonal::permisos', compact('id', 'empleado', 'urlArray'));
    }

    public function savePermisos(Request $request)
    {
    	if($request->method('post') || $request->ajax()){
    		$moreNames = explode("-", $request->input('name'));

    		foreach ($moreNames as $key => $value) {
    			# code...
    			#$route = $request->input('name');
	    		#$user_id = $request->input('id');
    			$route = $value;
    			$user_id = $request->input('id');
    			$existe = \Modules\MgPersonal\Entities\RoutesAccess::where(['alias_name' =>  $route, 'user_id' => $user_id])->get();

	    		if(count($existe) > 0){
	    			\Modules\MgPersonal\Entities\RoutesAccess::destroy($existe[0]->id);
	    		} else{
	    			\Modules\MgPersonal\Entities\RoutesAccess::create([
		    			"alias_name" => $route,
		    			"user_id" => $request->input('id')
		    		]);
	    		}
    		}
    		
    		return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
    	}
    }
}
