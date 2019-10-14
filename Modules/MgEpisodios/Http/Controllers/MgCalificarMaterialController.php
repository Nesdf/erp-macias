<?php

namespace Modules\MgEpisodios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\MgEpisodios\Entities\MaterialCalificado;
use Modules\MgEpisodios\Entities\Episodios;
use Modules\MgEpisodios\Entities\TimeCodes;
use Modules\MgEpisodios\Entities\Timecode;
use Modules\MgEpisodios\Entities\Tcr;
use Modules\MgEpisodios\Entities\Proyectos;
use Modules\MgEpisodios\Entities\TipoReporte;
use Modules\MgCatalogos\Entities\TipoError;
use Modules\MgPuestos\Entities\Puestos;

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
        try{

            if( $request->isMethod('post') && $request->ajax() ){

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
                        $calificacion = MaterialCalificado::create([      
                            'correo_activo' => Auth::user()->email,
                            'duracion' => $request->input('duracion'),
                            'tipo_reporte' => $request->input('reporte'),
                            'mezcla' => $request->input('mezcla'),
                            'tcr' => $request->input('tcr'),
                            'id_episodio' => $id,
                            'descripcion' => $request->input('observaciones')
                        ]);

                        if( $calificacion ){
                            Episodios::where( 'id',  $id)
                                ->update([  
                                    'material_calificado' => true 
                                ]);
                        }

                        $request->session()->flash('success', trans('mgepisodio::ui.flash.flash_create_timecode'));
                        return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                    }
                }
            } catch(\Exception $e){
                \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
                \Log::error(' Trace2: ' .$e->getTraceAsString());
                return Response(['error' => $e.getMessage()], 400)->header('Content-Type', 'application/json');
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

        try{

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
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    MaterialCalificado::select('id' , $request->input('id_episodio'))
                        ->update([ 
                            'duracion' => $request->input('duracion'),
                            'tipo_reporte' => $request->input('reporte'),
                            'mezcla' => $request->input('mezcla'),
                            'tcr' => $request->input('tcr'),
                            'descripcion' => $request->input('observaciones')
                        ]);

                    $request->session()->flash('success', trans('mgepisodios::ui.flash.flash_create_timecode'));
                    return redirect('/mgepisodios/material-calificado/'.$request->input('id_episodio').'/'.$request->input('id_proyecto'));
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
    public function destroy()
    {
    }

    public function materialCalificado($id_episodio, $id_proyecto)
    {
        try{

            $observaciones = Timecode::get();
            $tcrs = Tcr::All();
            $allProyect = Proyectos::allProyect($id_episodio, $id_proyecto);
            //dd($allProyect);
           
            $reportes = TipoReporte::get();
            $timecodes = TimeCodes::where('id_calificar_material', $allProyect[0]->id)->orderBy('timecode', 'desc')->get();
            $tipoErrores = TipoError::all();
            $editores = Puestos::editores();

            if($allProyect[0]->tipo_reporte == 'QC'){
                return view('mgepisodios::material-calificado-qc', compact('allProyect', 'tcrs', 'id_episodio', 'id_proyecto', 'timecodes', 'reportes', 'observaciones', 'tipoErrores', 'editores'));
            } else {
                return view('mgepisodios::material-calificado-video', compact('allProyect', 'tcrs', 'id_episodio', 'id_proyecto', 'timecodes', 'reportes', 'observaciones', 'tipoErrores', 'editores'));
            }

            
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
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
                    $observaciones = Timecode::get();
                    $tcrs = Tcr::All();
                    $allProyect = Proyectos::allProyect($id_episodio, $id_proyecto);
                    $timecodes = \Modules\MgEpisodios\Entities\TimeCodes::where('id_calificar_material', $allProyect[0]->id)->orderBy('timecode', 'asc')->get();
                    $reportes = \Modules\MgEpisodios\Entities\TipoReporte::get();
                    $request->session()->flash('success', trans('mgepisodios::ui.flash.flash_create_timecode'));
                    //return view('mgepisodios::material-calificado', compact('allProyect', 'reportes','tcrs', 'id_episodio', 'id_proyecto', 'timecodes', 'observaciones'));
                    return \Redirect()->back();
                }
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());        
        }      
    }

    public function pdf($id_episodio, $id_proyecto)
    {

        try{

            $allProyect = \Modules\MgEpisodios\Entities\Proyectos::allProyect($id_episodio, $id_proyecto);
            $timecodes = \Modules\MgEpisodios\Entities\TimeCodes::where('id_calificar_material', $allProyect[0]->id)->orderBy('timecode', 'asc')->get();
            //dd($allProyect[0]);
            if($allProyect[0]->tipo_reporte == 'QC'){
                $pdf = \PDF::loadView('mgepisodios::calificar-material-completo-pdf', compact('allProyect', 'id_episodio', 'id_proyecto', 'timecodes'));
            } else {
                $pdf = \PDF::loadView('mgepisodios::calificar-material-pdf', compact('allProyect', 'id_episodio', 'id_proyecto', 'timecodes'));
            }
            
            return $pdf->stream();
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());        
        }
    }
}
