<?php

namespace Modules\MgPersonal\Http\Controllers;
# Comentario de prueba

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\MgPersonal\Entities\Estudios;
use Modules\MgPersonal\Entities\User;
use Modules\MgPersonal\Entities\Jobs;
use \Modules\MgPersonal\Entities\RoutesAccess;
use Log;

class MgPersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
		$personas = User::Personal();
		$puestos = Jobs::get();
		$estudios = Estudios::get();
        return view('mgpersonal::personal', compact('personas', 'puestos', 'estudios'));
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
				'puesto' => 'required',
				'lista_estudios' => 'required'
				
			];
			
			$messages = [
				'nombre.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'nombre.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'nombre.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
				'ap_paterno.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
				'lista_estudios.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.lista_estudios')]),
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
				
				User::create([					
					'ap_paterno' => ucwords( strtolower($request->input('ap_paterno')) ),
					'ap_materno' => ucwords( strtolower($request->input('ap_materno')) ),
					'password' => Hash::make( $request->input('password') ),
					'email' => strtolower( $request->input('correo') ),
					'name' => ucwords( strtolower( $request->input('nombre') ) ),
					'lista_estudios' => $request->input('estudios'),
					'job' => $request->input('puesto'),
					'tipo_empleado' => $request->input('tipo_empleado') == 'on' ? true : false 
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
		try{ 
			if( $request->isMethod('post') && $request->ajax() ){

				$rules = [
					'nombre' => 'required|min:2|max:50',
					'ap_paterno' => 'required|min:2|max:50',
					'correo' => 'required|email',
					'puesto' => 'required',
					'lista_estudios' => 'required'
					
				];
				
				$messages = [
					'nombre.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
					'nombre.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
					'nombre.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.nombre')]),
					'ap_paterno.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
					'ap_paterno.min' => trans('mgpersonal::ui.display.error_min2', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
					'ap_paterno.max' => trans('mgpersonal::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.ap_paterno')]),
					'lista_estudios.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.lista_estudios')]),
					'correo.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.correo')]),
					'correo.email' => trans('mgpersonal::ui.display.error_email', ['attribute' => trans('mgpersonal::ui.attribute.correo')]),
					'puesto.required' => trans('mgpersonal::ui.display.error_required', ['attribute' => trans('mgpersonal::ui.attribute.puesto')])
				]; 
				
				$validator = \Validator::make($request->all(), $rules, $messages);			
				
				if ( $validator->fails() ) {
					return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
				} else {
					
					$data = array(
						'ap_paterno' => ucwords( strtolower($request->input('ap_paterno')) ),
						'ap_materno' => ucwords( strtolower($request->input('ap_materno')) ),
						'email' => strtolower( $request->input('correo') ),
						'name' => ucwords( strtolower($request->input('nombre')) ),
						//'lista_estudios' => $request->input('estudios'),
						'job' => $request->input('puesto'),
						'tipo_empleado' => $request->input('tipo_empleado') == 'on' ? true : false 
					);

					if(!User::verificarEstudios($request->estudios)){
						$data['lista_estudios'] = $request->estudios;
					}

					if( $request->input('password') != '' ){
						$data['password'] = \Hash::make($request->input('password'));
					}

					$updateData = User::where('id', $request->input('id'))
					->update( $data );

					

					$request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_personal'));

					return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
				}
			}	
		 } catch( \Exception $e ){

            Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            Log::error(' Trace2: ' .$e->getTraceAsString());
            return response()->json([
              'response' => 'error',
              'msg1' => $e->getTraceAsString(),
              'code' => 400
            ]);
        }
    }
	
    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
		\Modules\MgPersonal\Entities\User::destroy($id);
		\Request::session()->flash('message', trans('mgpersonal::ui.flash.flash_delete_personal'));
		return redirect('mgpersonal');
    }

    public function permisos($id)
    {
    	$urls = RoutesAccess::where('user_id', $id)->get();
    	$urlArray=array();
    	foreach ($urls as $value) {
    		$urlArray[$value->alias_name] = $value->alias_name;
    	}
    	$empleado = \Modules\MgPersonal\Entities\User::Empleado($id);
    	return view('mgpersonal::permisos', compact('id', 'empleado', 'urlArray'));
    }

    public function savePermisos(Request $request)
    {
    	try{

    		if($request->isMethod('post') || $request->ajax()){	

	    		$moreNames = explode("-", $request->input('name'));
	    		$status = $request->input('status');
	    		$user_id = $request->input('id');

	    		if( $status == 'off' ){

	    			foreach($moreNames as $value){

	    				\Modules\MgPersonal\Entities\RoutesAccess::DeletePermiso($user_id, $value);
	    			}
	    		} elseif( $status == 'on' ){

	    			foreach ($moreNames as $value) {

	    				\Modules\MgPersonal\Entities\RoutesAccess::create([
			    			"alias_name" => $value,
			    			"user_id" => $request->input('id')
			    		]);
	    			}
	    		}
	    		return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
	    	}
    	} catch(\Exception $e){
    		return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
    	}
    }
}
