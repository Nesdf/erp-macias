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
		try{

            $puestos = \Modules\MgPersonal\Entities\Jobs::get();
            return view('mgpuestos::index', compact('puestos'));
        } catch(\Exception $e){
            return $e->getMessage();
        }
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
		try {

            if( $request->isMethod('post') && $request->ajax() ){
            
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
                    return Response(['validation' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    \Modules\MgClientes\Entities\Puestos::create([  
                        'job' => ucwords(strtolower($request->input('job')))
                    ]);
                    $request->session()->flash('success', trans('mgpuestos::ui.flash.flash_create_puesto'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }
            }
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
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
        try{

            return \Modules\MgClientes\Entities\Puestos::find($id);
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
		try {

            if( $request->isMethod('post') && $request->ajax() ){
            
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
                    return Response(['validation' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    \Modules\MgClientes\Entities\Puestos::where('id', $request->input('id'))
                    ->update([                  
                        'job' => ucwords(strtolower($request->input('job')))
                    ]);
                    $request->session()->flash('success', trans('mgpuestos::ui.flash.flash_create_puesto'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
		try{

            \Modules\MgClientes\Entities\Puestos::destroy($id);
            \Request::session()->flash('success', trans('mgpuestos::ui.flash.flash_delete_puesto'));
            return redirect('mgpuestos');
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
