<?php

namespace Modules\MgClientes\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
		$clientes = \Modules\MgClientes\Entities\Clientes::clientes_relation();
        $paises = \Modules\MgClientes\Entities\Paises::get();
		$estados = \Modules\MgClientes\Entities\Estados::get();
		$puestos = \Modules\MgClientes\Entities\Puestos::get();
        return view('mgclientes::index', compact('paises', 'clientes', 'puestos', 'estados'));
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
				\Modules\MgClientes\Entities\Clientes::create([					
					'razon_social' => ( $request->input('razon_social') ) ?  ucwords( $request->input('razon_social') ) : '',
					'rfc' => strtoupper( $request->input('rfc') ),
					'paisId' => $request->input('pais'),
					'estadoId' => $request->input('localidad')
				]);
				$request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_cliente'));
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
				$request->session()->flash('message', trans('mgclientes::ui.flash.flash_create_cliente'));
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
		\Modules\MgClientes\Entities\Clientes::destroy($id);
		\Request::session()->flash('message', trans('mgclientes::ui.flash.flash_delete_peronal'));
		return redirect('mgclientes');
    }
	
	public function list_countries($id)
	{
		$estados = \Modules\MgClientes\Entities\Estados::lista_countries($id);
		return Response(['msg' => $estados], 200)->header('Content-Type', 'application/json');
		
	}
}
