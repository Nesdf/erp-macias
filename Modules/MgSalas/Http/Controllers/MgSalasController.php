<?php

namespace Modules\MgSalas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgSalasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try{

            $salas = \Modules\MgSalas\Entities\Salas::salasAll();
            $estudios = \Modules\MgSalas\Entities\Estudios::get();
            return view('mgsalas::index', compact('salas', 'estudios'));
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
        return view('mgsalas::create');
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
                    'sala' => 'required|min:2|max:50',   
                    'estudio' => 'required'
                ];
                
                $messages = [
                    'sala.required' => trans('mgsalas::ui.display.error_required', ['attribute' => trans('mgsalas::ui.attribute.sala')]),
                    'sala.min' => trans('mgsalas::ui.display.error_min2', ['attribute' => trans('mgsalas::ui.attribute.sala')]),
                    'sala.max' => trans('mgsalas::ui.display.error_max50', ['attribute' => trans('mgsalas::ui.attribute.sala')]),
                    'estudio.required' => "El campo estudio es requerido"
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    \Modules\MgSalas\Entities\Salas::create([  
                        'sala' => ucwords( $request->input('sala') ),
                        'estudio_id' => strtoupper($request->input('estudio'))
                    ]);
                    $request->session()->flash('success', trans('mgsalas::ui.flash.flash_create_sala'));
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
        return view('mgsalas::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
         return \Modules\MgSalas\Entities\Salas::find($id); 
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
                    'sala' => 'required|min:2|max:50'                
                ];
                
                $messages = [
                    'sala.required' => trans('mgsalas::ui.display.error_required', ['attribute' => trans('mgsalas::ui.attribute.sala')]),
                    'sala.min' => trans('mgsalas::ui.display.error_min2', ['attribute' => trans('mgsalas::ui.attribute.sala')]),
                    'sala.max' => trans('mgsalas::ui.display.error_max50', ['attribute' => trans('mgsalas::ui.attribute.sala')])
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    \Modules\MgSalas\Entities\Salas::where('id', $request->input('id'))
                    ->update([                  
                        'sala' => strtoupper( $request->input('sala') ),
                        'estudio_id' => $request->input('estudio')
                    ]);
                    $request->session()->flash('success', trans('mgsalas::ui.flash.flash_create_sala'));
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
        \Modules\MgSalas\Entities\Salas::destroy($id);
        \Request::session()->flash('success', 'Se eliminó correctamente.');
        return redirect('mgsalas');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function storeEstudio(Request $request)
    {
        try{

            if( $request->method('post') && $request->ajax() ){
            
                $rules = [
                    'estudio' => 'required|min:2|max:50'                
                ];
                
                $messages = [
                    'estudio.required' => 'Estudio es requerido.'
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                }

                \Modules\MgSalas\Entities\Estudios::create([
                    'estudio' => strtoupper($request->input('estudio'))
                    ]);
                $request->session()->flash('success', 'El estudio fue creado satisfactoriamente.');
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
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
    public function editEstudio(Request $request)
    {
        try{

            if( $request->method('post') && $request->ajax() ){
            
                $rules = [
                    'estudio' => 'required|min:2|max:50'                
                ];
                
                $messages = [
                    'estudio.required' => 'Estudio es requerido.'
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                }

                \Modules\MgSalas\Entities\Estudios::where('id', $request->input('id'))
                ->update([
                    'estudio' => strtoupper($request->input('estudio'))
                    ]);
                $request->session()->flash('success', 'El estudio fue modificado satisfactoriamente.');
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        } catch(\Exception $e){

            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }
}
