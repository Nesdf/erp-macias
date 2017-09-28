<?php

namespace Modules\MgEpisodios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class MgEpisodiosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {
        $proyecto = \Modules\MgEpisodios\Entities\Proyectos::find($id);
        $vias = \Modules\MgEpisodios\Entities\Vias::get();
        $proyecto_id = $id;
        $episodios = \Modules\MgEpisodios\Entities\Episodios::allEpisodioOfProject($id);
        $tcrs = \Modules\MgEpisodios\Entities\Tcr::All();
        $salas = \Modules\MgEpisodios\Entities\Salas::All();
        $productores = \Modules\MgEpisodios\Entities\Users::Productores();
        $responsables = \Modules\MgEpisodios\Entities\Users::All();
        return view('mgepisodios::index', compact('proyecto', 'vias', 'proyecto_id', 'episodios', 'tcrs', 'salas', 'productores', 'responsables'));
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
        if( $request->method('post') && $request->ajax() ){
            
            $rules = [
                'titulo_original_episodio' => 'required|min:2|max:50',
                'via' => 'required',
                'proyectoId' => 'required',
                'num_episodio' => 'required',
                'entrega_episodio' => 'required',
            ];
            
            $messages = [
                'titulo_original_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.titulo_original_episodio')]),
                'titulo_original_episodio.min' => trans('mgepisodios::ui.display.error_min2', ['attribute' => trans('mgepisodios::ui.attribute.titulo_original_episodio')]),
                'titulo_original_episodio.max' => trans('mgepisodios::ui.display.error_max50', ['attribute' => trans('mgepisodios::ui.attribute.titulo_original_episodio')]),
                'via.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.via')]),
                'num_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.num_episodio')]),
                'entrega_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.entrega_episodio')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\mgepisodios\Entities\Episodios::create([      
                    'titulo_original' => ucwords( $request->input('titulo_original_episodio') ),
                    'titulo_espanol' => ( $request->input('titulo_episodio_espanol') ) ? ucwords( $request->input('titulo_episodio_espanol') ) : null,
                    'titulo_ingles' => ($request->input('titulo_episodio_ingles'))? ucwords( $request->input('titulo_episodio_ingles') ) : null,
                    'titulo_portugues' => ($request->input('titulo_episodio_portugues'))? ucwords( $request->input('titulo_episodio_portugues') ) : null,
                    'duracion' => ucwords( $request->input('duracion') ),
                    'viaId' => ucwords( $request->input('via') ),
                    'proyectoId' => $request->input('proyectoId'),
                    'num_episodio' => ucwords( $request->input('num_episodio') ),
                    'observaciones' => ucwords( $request->input('observaciones') ),
                    'date_m_and_e' => $request->input('date_m_and_e'),
                    'productor' => $request->input('productor'),
                    'responsable' => $request->input('responsable'),
                    'salaId' => $request->input('sala'),
                    'date_entrega' => $request->input('entrega_episodio') ,
                    'dobl_espanol20' => ( $request->input('doblaje_espanol20') ) ? true : false,
                    'dobl_espanol51' => ( $request->input('doblaje_espanol51') ) ? true : false,
                    'dobl_espanol71' => ( $request->input('doblaje_espanol71') ) ? true : false,
                    'dobl_ingles20' => ( $request->input('doblaje_ingles20') ) ? true : false,
                    'dobl_ingles51' => ( $request->input('doblaje_ingles51') ) ? true : false,
                    'dobl_ingles71' => ( $request->input('doblaje_ingles71') ) ? true : false,
                    'dobl_portugues20' => ( $request->input('doblaje_portugues20') ) ? true : false,
                    'dobl_portugues51' => ( $request->input('doblaje_portugues51') ) ? true : false,
                    'dobl_portugues71' => ( $request->input('doblaje_portugues71') ) ? true : false,
                    'subt_espanol' => ( $request->input('subtitulaje_espanol') ) ? true : false,
                    'subt_ingles' => ( $request->input('subtitulaje_ingles') ) ? true : false,
                    'subt_portugues' => ( $request->input('subtitulaje_portugues') ) ? true : false,
                    'material_calificado' => false,
                    'material_entregado' => false
                ]);
                $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        $episodio =  \Modules\MgEpisodios\Entities\Episodios::findEpisodio($id);

        $hoy = Carbon::today('America/Mexico_City');
        $fechaentrega = Carbon::parse($episodio[0]->date_entrega, 'America/Mexico_City');
        $diferencia_dias = $fechaentrega->diffInDays($hoy, false);
        $status_entrega ="";
        if($diferencia_dias < -2){
            $status_entrega = "success";
        }
        if($diferencia_dias >= -2 && $diferencia_dias <= -1){
            $status_entrega = "warning";
        }
        if($diferencia_dias >= 0){
            $status_entrega = "danger";
        }
         return Response(['msg' => $episodio, 'status_entrega' => $status_entrega], 200)->header('Content-Type', 'application/json');
        
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgEpisodios\Entities\Episodios::find($id); 
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
                'titulo_original_episodio' => 'required|min:2|max:50',
                'via' => 'required',
                'proyectoId' => 'required',
                'num_episodio' => 'required',
                'entrega_episodio' => 'required',
            ];
            
            $messages = [
                'titulo_original_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.titulo_original_episodio')]),
                'titulo_original_episodio.min' => trans('mgepisodios::ui.display.error_min2', ['attribute' => trans('mgepisodios::ui.attribute.titulo_original_episodio')]),
                'titulo_original_episodio.max' => trans('mgepisodios::ui.display.error_max50', ['attribute' => trans('mgepisodios::ui.attribute.titulo_original_episodio')]),
                'via.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.via')]),
                'num_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.num_episodio')]),
                'entrega_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.entrega_episodio')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\mgepisodios\Entities\Episodios::where('id', $request->input('id'))
                    ->update([      
                        'titulo_original' => ucwords( $request->input('titulo_original_episodio') ),
                        'titulo_espanol' => ( $request->input('titulo_episodio_espanol') ) ? ucwords( $request->input('titulo_episodio_espanol') ) : null,
                        'titulo_ingles' => ($request->input('titulo_episodio_ingles'))? ucwords( $request->input('titulo_episodio_ingles') ) : null,
                        'titulo_portugues' => ($request->input('titulo_episodio_portugues'))? ucwords( $request->input('titulo_episodio_portugues') ) : null,
                        'duracion' => ucwords( $request->input('duracion') ),
                        'viaId' => ucwords( $request->input('via') ),
                        'proyectoId' => $request->input('proyectoId'),
                        'num_episodio' => ucwords( $request->input('num_episodio') ),
                        'observaciones' => ucwords( $request->input('observaciones') ),
                        'salaId' => $request->input('sala'),
                        'date_m_and_e' => $request->input('date_m_and_e'),
                        'productor' => $request->input('productor'),
                        'responsable' => $request->input('responsable'),
                        'date_entrega' => $request->input('entrega_episodio') ,
                        'dobl_espanol20' => ( $request->input('doblaje_espanol20') ) ? true : false,
                        'dobl_espanol51' => ( $request->input('doblaje_espanol51') ) ? true : false,
                        'dobl_espanol71' => ( $request->input('doblaje_espanol71') ) ? true : false,
                        'dobl_ingles20' => ( $request->input('doblaje_ingles20') ) ? true : false,
                        'dobl_ingles51' => ( $request->input('doblaje_ingles51') ) ? true : false,
                        'dobl_ingles71' => ( $request->input('doblaje_ingles71') ) ? true : false,
                        'dobl_portugues20' => ( $request->input('doblaje_portugues20') ) ? true : false,
                        'dobl_portugues51' => ( $request->input('doblaje_portugues51') ) ? true : false,
                        'dobl_portugues71' => ( $request->input('doblaje_portugues71') ) ? true : false,
                        'subt_espanol' => ( $request->input('subtitulaje_espanol') ) ? true : false,
                        'subt_ingles' => ( $request->input('subtitulaje_ingles') ) ? true : false,
                        'subt_portugues' => ( $request->input('subtitulaje_portugues') ) ? true : false,
                        'material_entregado' => false
                    ]);
                $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id, $id_proyecto)
    {
        $eliminar = \Modules\MgEpisodios\Entities\Episodios::destroy($id);
        if($eliminar){
            \Modules\MgEpisodios\Entities\Episodios::eliminarCalificacion($id);
        }
        \Request::session()->flash('message', trans('mgclientes::ui.flash.flash_delete_episodio'));
        return redirect('mgepisodios/'.$id_proyecto);
    }
}
