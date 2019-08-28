<?php

namespace Modules\MgClientes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgClientes\Entities\Clientes;

class MgClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
    	try{

			$clientes = Clientes::clientes_relation();
			$c = Clientes::all();
	        $paises = \Modules\MgClientes\Entities\Paises::get();
			$estados = \Modules\MgClientes\Entities\Estados::get();
			$puestos = \Modules\MgClientes\Entities\Puestos::get();
			\Log::error(' clientes Log: ' .$clientes);
			\Log::error(' clientes Log2: ' .$c);
	        return view('mgclientes::index2', compact('paises', 'clientes', 'puestos', 'estados'));
    	} catch(\Exception $e){

            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
		
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgclientes::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		try{

			if( $request->method('post') && $request->ajax() ){
			
				$rules = [
					//'razon_social' => 'required|min:13|max:14|regex:/^[A-Za-z0-9\s]+$/g',
					'pais' => 'required',
					'localidad' => 'required'
					
				];
				
				$messages = [
					//'razon_social.required' => 'Formato incorrecto del RFC',
					//'razon_social.min' => 'Formato incorrecto del RFC',
					//'razon_social.max' => 'Formato incorrecto del RFC',
					'pais.required' => 'Formato incorrecto del RFC',
					'razon_social.regex' => 'Formato incorrecto del RFC',
					'localidad.required' => 'Formato incorrecto del RFC'
				]; 
				
				$validator = \Validator::make($request->all(), $rules, $messages);			
				
				if ( $validator->fails() ) {
					return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
				} else {
					\Modules\MgClientes\Entities\Clientes::create([					
						'razon_social' => strtoupper( $request->razon_social ),
						'rfc' => $request->rfc,
						'paisId' => $request->pais,
						'estadoId' => $request->localidad
					]);
					$request->session()->flash('success', trans('mgclientes::ui.flash.flash_create_cliente'));
					return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
				}
			}
		} catch(\Exception $e){

			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgclientes::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgClientes\Entities\Clientes::find($id); 
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
		try{

			if( $request->method('post') && $request->ajax() ){
			
				$rules = [
					'razon_social' => 'required|min:2|max:50',
					'pais' => 'required',
					'localidad' => 'required'
					
				];
				
				$messages = [
					'razon_social.required' => trans('mgclientes::ui.display.error_required', ['attribute' => trans('mgclientes::ui.attribute.razon_social')]),
					'razon_social.min' => trans('mgclientes::ui.display.error_min2', ['attribute' => trans('mgclientes::ui.attribute.razon_social')]),
					'razon_social.max' => trans('mgclientes::ui.display.error_max50', ['attribute' => trans('mgclientes::ui.attribute.razon_social')]),
					'pais.required' => trans('mgclientes::ui.display.error_required', ['attribute' => trans('mgclientes::ui.attribute.pais')]),
					'localidad.required' => trans('mgclientes::ui.display.error_required', ['attribute' => trans('mgclientes::ui.attribute.localidad')])
				]; 
				
				$validator = \Validator::make($request->all(), $rules, $messages);			
				
				if ( $validator->fails() ) {
					return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
				} else {
					\Modules\MgClientes\Entities\Clientes::where('id', $request->input('id'))
					->update([					
						'razon_social' => ( $request->input('razon_social') ) ?  ucwords( $request->input('razon_social') ) : '',
						'rfc' => strtoupper( $request->input('rfc') ),
						'paisId' => $request->input('pais'),
						'estadoId' => $request->input('localidad')
					]);
					$request->session()->flash('success', trans('mgclientes::ui.flash.flash_create_cliente'));
					return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
				}
			}
		} catch(\Exception $e){

			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
		try{

			\Modules\MgClientes\Entities\Clientes::destroy($id);
			\Request::session()->flash('success', trans('mgclientes::ui.flash.flash_delete_cliente'));
			return redirect('mgclientes');
		} catch(\Exception $e){

			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
    }
	
	public function list_countries($id)
	{
		try{

			$estados = \Modules\MgClientes\Entities\Estados::lista_countries($id);
			return Response(['msg' => $estados], 200)->header('Content-Type', 'application/json');
		} catch(\Exception $e){

			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
	}
}
