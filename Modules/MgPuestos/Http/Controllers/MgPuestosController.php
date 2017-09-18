<?php

namespace Modules\MgPuestos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgPuestosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
		$puestos = \Modules\MgPersonal\Entities\Jobs::get();
        return view('mgpuestos::index', compact('puestos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgpuestos::create');
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
				'job' => 'required|min:2|max:50'				
			];
			
			$messages = [
				'job.required' => trans('mgpuestos::ui.display.error_required', ['attribute' => trans('mgpuestos::ui.attribute.job')]),
				'job.min' => trans('mgpuestos::ui.display.error_min2', ['attribute' => trans('mgpuestos::ui.attribute.job')]),
				'job.max' => trans('mgpuestos::ui.display.error_max50', ['attribute' => trans('mgpuestos::ui.attribute.job')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {
				\Modules\MgClientes\Entities\Puestos::create([	
					'job' => $request->input('job')
				]);
				$request->session()->flash('message', trans('mgpuestos::ui.flash.flash_create_cliente'));
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
        return view('mgpuestos::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgClientes\Entities\Puestos::find($id); 
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
				'job' => 'required|min:2|max:50'				
			];
			
			$messages = [
				'job.required' => trans('mgpuestos::ui.display.error_required', ['attribute' => trans('mgpuestos::ui.attribute.job')]),
				'job.min' => trans('mgpuestos::ui.display.error_min2', ['attribute' => trans('mgpuestos::ui.attribute.job')]),
				'job.max' => trans('mgpuestos::ui.display.error_max50', ['attribute' => trans('mgpuestos::ui.attribute.job')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {
				\Modules\MgClientes\Entities\Puestos::where('id', $request->input('id'))
				->update([					
					'job' => $request->input('job')
				]);
				$request->session()->flash('message', trans('mgclientes::ui.flash.flash_create_puesto'));
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
		\Modules\MgClientes\Entities\Puestos::destroy($id);
		\Request::session()->flash('message', trans('mgpuestos::ui.flash.flash_delete_puesto'));
		return redirect('mgpuestos');
    }
}
