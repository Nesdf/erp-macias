<?php

namespace Modules\MgEpisodios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MgCalificarMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('mgepisodios::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgepisodios::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if( $request->isMethod('post') && $request->ajax() ){

            try{

                $rules = [
                    'duracion' => 'required|min:2|max:50',
                    'tcr' => 'required'
                ];
                
                $messages = [
                    'duracion.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.duracion')]),
                    'tcr.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.tcr')])
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    $id = $request->input('id');
                    $calificacion = \Modules\MgEpisodios\Entities\MaterialCalificado::create([      
                        'correo_activo' => Auth::user()->email,
                        'duracion' => $request->input('duracion'),
                        'tipo_reporte' => $request->input('reporte'),
                        'mezcla' => $request->input('mezcla'),
                        'tcr' => $request->input('tcr'),
                        'id_episodio' => $id,
                        'descripcion' => $request->input('observaciones')
                    ]);

                    if( $calificacion ){
                        \Modules\MgEpisodios\Entities\Episodios::where( 'id',  $id)
                            ->update([  
                                'material_calificado' => true 
                            ]);
                    }

                    $request->session()->flash('message', trans('mgepisodio::ui.flash.flash_create_cliente'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }
            } catch(\Exception $e){
                return Response(['error' => $e.getMessage()], 400)->header('Content-Type', 'application/json');
            }

        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgepisodios::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgepisodios::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {

        if( $request->isMethod('post') ){
            
            $rules = [
                'duracion' => 'required|min:2|max:50',
                'tcr' => 'required'
            ];
            
            $messages = [
                'duracion.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.duracion')]),
                'tcr.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.tcr')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return  "Error";
            } else {
                \Modules\MgEpisodios\Entities\MaterialCalificado::select('id' , $request->input('id_episodio'))
                    ->update([ 
                        'duracion' => $request->input('duracion'),
                        'tipo_reporte' => $request->input('reporte'),
                        'mezcla' => $request->input('mezcla'),
                        'tcr' => $request->input('tcr'),
                        'descripcion' => $request->input('observaciones')
                    ]);

                return redirect('/mgepisodios/material-calificado/'.$request->input('id_episodio').'/'.$request->input('id_proyecto'));
            }

        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function materialCalificado($id_episodio, $id_proyecto)
    {

        $observaciones = \Modules\MgEpisodios\Entities\Timecode::get();
        $tcrs = \Modules\MgEpisodios\Entities\Tcr::All();
        $allProyect = \Modules\MgEpisodios\Entities\Proyectos::allProyect($id_episodio, $id_proyecto);
        $reportes = \Modules\MgEpisodios\Entities\TipoReporte::get();
        $timecodes = \Modules\MgEpisodios\Entities\TimeCodes::where('id_calificar_material', $allProyect[0]->id)->orderBy('timecode', 'desc')->get();
        return view('mgepisodios::material-calificado', compact('allProyect', 'tcrs', 'id_episodio', 'id_proyecto', 'timecodes', 'reportes', 'observaciones'));
    }

    public function saveTimecode(Request $request)
    {
        try{
            //dd($request->all());
            if( $request->isMethod('post') ){

                $rules = [
                    'timecode' => 'required'
                ];
                
                $messages = [
                    'timecode.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.timecode')])
                ]; 

                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return  $validator->errors()->all();
                } else {
                    $id_proyecto = $request->input('id_proyecto');
                    $id_episodio = $request->input('id_episodio');
                    \Modules\MgEpisodios\Entities\TimeCodes::create([ 
                            'timecode' => $request->input('timecode'),
                            'fecha' => \Carbon\carbon::now(),
                            'timecode_final' => ($request->input('music') == 'on') ?  $request->input('timecode_final') : null ,
                            'id_calificar_material' => $request->input('id_cm'),
                            'observaciones' => $request->input('observaciones')
                        ]);

                    //return redirect('/mgepisodios/material-calificado/'.$request->input('id_episodio').'/'.$request->input('id_proyecto'));
                    $observaciones = \Modules\MgEpisodios\Entities\Timecode::get();
                    $tcrs = \Modules\MgEpisodios\Entities\Tcr::All();
                    $allProyect = \Modules\MgEpisodios\Entities\Proyectos::allProyect($id_episodio, $id_proyecto);
                    $timecodes = \Modules\MgEpisodios\Entities\TimeCodes::where('id_calificar_material', $allProyect[0]->id)->orderBy('timecode', 'asc')->get();
                    $reportes = \Modules\MgEpisodios\Entities\TipoReporte::get();

                    return view('mgepisodios::material-calificado', compact('allProyect', 'reportes','tcrs', 'id_episodio', 'id_proyecto', 'timecodes', 'observaciones'));
                }
            }
        } catch(\Exception $e){
            return $e->getMessage();
        }      
    }

    public function pdf($id_episodio, $id_proyecto)
    {

        $allProyect = \Modules\MgEpisodios\Entities\Proyectos::allProyect($id_episodio, $id_proyecto);
        $timecodes = \Modules\MgEpisodios\Entities\TimeCodes::where('id_calificar_material', $allProyect[0]->id)->orderBy('timecode', 'asc')->get();
        
        $pdf = \PDF::loadView('mgepisodios::calificar-material-pdf', compact('allProyect', 'id_episodio', 'id_proyecto', 'timecodes'));
        return $pdf->stream();
    }
}
