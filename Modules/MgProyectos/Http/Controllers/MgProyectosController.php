<?php

namespace Modules\MgProyectos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
		$proyectos = \Modules\MgProyectos\Entities\Proyectos::fullProyects();
        $clientes = \Modules\MgProyectos\Entities\Clientes::get();
        $idiomas = \Modules\MgProyectos\Entities\Idiomas::get();
        return view('mgproyectos::index', compact('idiomas', 'clientes', 'proyectos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgproyectos::create');
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
				'cliente' => 'required',
				'titulo_proyecto' => 'required'
				
			];
			
			$messages = [
				'cliente.required' => trans('mgproyectos::ui.display.error_required', ['attribute' => trans('mgproyectos::ui.attribute.cliente')]),
				'titulo_proyecto.required' => trans('mgproyectos::ui.display.error_required', ['attribute' => trans('mgproyectos::ui.attribute.titulo_proyecto')]),
				'titulo_proyecto.min' => trans('mgproyectos::ui.display.error_min2', ['attribute' => trans('mgproyectos::ui.attribute.titulo_proyecto')]),
				'titulo_proyecto.max' => trans('mgproyectos::ui.display.error_max255', ['attribute' => trans('mgproyectos::ui.attribute.titulo_proyecto')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {
				if( $request->input('mande') ){
					\Modules\MgProyectos\Entities\Proyectos::create([					
						'clienteId' => $request->input('cliente'),
						'titulo_original' => ucwords( $request->input('titulo_serie') ),
						'titulo_aprobado' => ucwords( $request->input('titulo_proyecto') ),
						'statusId' => true,
						'm_and_e' => true
					]);
				} else {
					\Modules\MgProyectos\Entities\Proyectos::create([					
						'clienteId' => $request->input('cliente'),
						'titulo_original' => ucwords( $request->input('titulo_serie') ),
						'titulo_aprobado' => ucwords( $request->input('titulo_proyecto') ),
						'statusId' => true,
						'm_and_e' => false
					]);
				}
				
				$request->session()->flash('message', trans('mgproyectos::ui.flash.flash_create_cliente'));
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
        return view('mgproyectos::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgProyectos\Entities\Proyectos::find($id); 
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
				'cliente' => 'required',
				'titulo_proyecto' => 'required'
				
			];
			
			$messages = [
				'cliente.required' => trans('mgproyectos::ui.display.error_required', ['attribute' => trans('mgproyectos::ui.attribute.cliente')]),
				'titulo_proyecto.required' => trans('mgproyectos::ui.display.error_required', ['attribute' => trans('mgproyectos::ui.attribute.titulo_proyecto')]),
				'titulo_proyecto.min' => trans('mgproyectos::ui.display.error_min2', ['attribute' => trans('mgproyectos::ui.attribute.titulo_proyecto')]),
				'titulo_proyecto.max' => trans('mgproyectos::ui.display.error_max255', ['attribute' => trans('mgproyectos::ui.attribute.titulo_proyecto')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {
				if( $request->input('mande') ){
					\Modules\MgProyectos\Entities\Proyectos::where('id', $request->input('id'))
					->update([					
						'clienteId' => $request->input('cliente'),
						'titulo_original' => ucwords( $request->input('titulo_serie') ),
						'titulo_aprobado' => ucwords( $request->input('titulo_proyecto') ),
						'statusId' => true,
						'm_and_e' => true
					]);
				} else {
					if( $request->input('mande') ){
					\Modules\MgProyectos\Entities\Proyectos::where('id', $request->input('id'))
					->update([					
						'clienteId' => $request->input('cliente'),
						'titulo_original' => ucwords( $request->input('titulo_serie') ),
						'titulo_aprobado' => ucwords( $request->input('titulo_proyecto') ),
						'statusId' => true,
						'm_and_e' => true
					]);
					} else {
						\Modules\MgProyectos\Entities\Proyectos::where('id', $request->input('id'))
						->update([					
							'clienteId' => $request->input('cliente'),
							'titulo_original' => ucwords( $request->input('titulo_serie') ),
							'titulo_aprobado' => ucwords( $request->input('titulo_proyecto') ),
							'statusId' => true,
							'm_and_e' => false
						]);
					}
				}
				
				$request->session()->flash('message', trans('mgproyectos::ui.flash.flash_create_cliente'));
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
		\Modules\MgProyectos\Entities\Proyectos::destroy($id);
		\Request::session()->flash('message', trans('mgproyectos::ui.flash.flash_delete_proyecto'));
		return redirect('mgproyectos');
    }
}
