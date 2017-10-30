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
        
        $proyecto_id = $id;
        $episodios = \Modules\MgEpisodios\Entities\Episodios::allEpisodioOfProject($id);

        #dd($episodios);
        $tcrs = \Modules\MgEpisodios\Entities\Tcr::All();
        $salas = \Modules\MgEpisodios\Entities\Salas::All();
        $productores = \Modules\MgEpisodios\Entities\Users::Productores();
        $responsables = \Modules\MgEpisodios\Entities\Users::Responsables();
        $traductores = \Modules\MgEpisodios\Entities\Users::traductores();
        $reportes = \Modules\MgEpisodios\Entities\TipoReporte::get();
        return view('mgepisodios::index', compact('proyecto', 'proyecto_id', 'episodios', 'tcrs', 'salas', 'productores', 'responsables', 'traductores', 'reportes'));
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
                'entrega_episodio' => 'required',
            ];
            
            $messages = [
                'entrega_episodio.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.entrega_episodio')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                 Carbon::today('America/Mexico_City');
                $hoy = Carbon::now();
                \Modules\MgEpisodios\Entities\Episodios::create([      
                    'titulo_original' => ucwords( $request->input('titulo_original_episodio') ),
                    'bw' => ($request->input('bw') == 'on') ? true : false ,
                    'netcut' => ($request->input('netcut') == 'on') ? true : false ,
                    'lockcut' => ($request->input('lockcut') == 'on') ? true : false ,
                    'final' => ($request->input('final') == 'on') ? true : false ,
                    'date_bw' => ($request->input('bw') == 'on') ? $hoy : null ,
                    'date_netcut' => ($request->input('netcut') == 'on') ? $hoy : null ,
                    'date_lockcut' => ($request->input('lockcut') == 'on') ? $hoy : null ,
                    'date_final' => ($request->input('final') == 'on') ? $hoy : null ,
                    'date_entrega' => $request->input('entrega_episodio') ,
                    'proyectoId' => $request->input('proyectoId'),
                    'configuracion' => $request->input('configuracion'),
                    'num_episodio' => ucwords( $request->input('num_episodio') ),
                    'date_m_and_e' => $request->input('entrega_me'),
                    'productor' => $request->input('productor'),
                    'folio' => $request->input('folio'),
                    'responsable' => $request->input('responsable'),
                    'salaId' => $request->input('sala'),
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
                'proyectoId' => 'required',
            ];
            
            $messages = [
                'proyectoId.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.entrega_episodio')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                try{
                    \Modules\MgEpisodios\Entities\Episodios::where('id', $request->input('id'))
                        ->update([      
                            'titulo_original' => ucwords( $request->input('titulo_original_episodio') ),
                            'configuracion' => $request->input('configuracion'),
                            'date_entrega' => $request->input('entrega_episodio') ,
                            'proyectoId' => $request->input('proyectoId'),
                            'configuracion' => $request->input('configuracion'),
                            'num_episodio' => $request->input('num_episodio'),
                            'date_m_and_e' => $request->input('entrega_me'),
                            'productor' => $request->input('productor'),
                            'responsable' => $request->input('responsable'),
                            'folio' => $request->input('folio'),
                            'salaId' => $request->input('sala')
                        ]);
                        $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
                        return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                       
                } catch(\Exception $e){
                    report($e);
                    return false;
                }
                
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

    public function assignTraductor(Request $request)
    {
        if( $request->method('post') && $request->ajax() ){
            $rules = [
                'fecha_entrega_traductor' => 'required',
                'traductor' => 'required'
            ];
            
            $messages = [
                'fecha_entrega_traductor.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.fecha_entrega_traductor')]),
                'traductor.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.traductor')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);   
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                try{
                    $hoy = Carbon::today('America/Mexico_City');
                    $update = \Modules\mgepisodios\Entities\Episodios::where('id', $request->input('episodioId'))
                        ->update([      
                            'fecha_asignacion_traductor' => $hoy->now(),
                            'fecha_entrega_traductor' => $request->input('fecha_entrega_traductor'),
                            'salaId' => $request->input('sala'),
                            'script' => ( $request->input('script') == 'on') ? true : false,
                            'rayado' => ( $request->input('rayado') == 'on') ? true : false,
                            'traductorId' => $request->input('traductor'),
                            'status_coordinador' => true

                        ]);
                        if(!$update){
                            return "Fallido";
                        }

                    $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }catch(Exception $e){
                     report($e);
                     return false;
                }
            }
        }
    }

    public function updateConfiguration(Request $request)
    {
        Carbon::today('America/Mexico_City');
        $hoy = Carbon::now();

        $data = [];

        if($request->input('bw') == 'on'){
            $data = ['bw' => $request->input('bw'), 'date_bw' => $hoy];
        }
        if($request->input('netcut') == 'on'){
            $data = ['netcut' => $request->input('netcut'), 'date_netcut' => $hoy];
        }
        if($request->input('lockcut') == 'on'){
            $data = ['lockcut' => $request->input('lockcut'), 'date_lockcut' => $hoy];
        }
        if($request->input('final') == 'on'){
            $data = ['final' => $request->input('final'), 'date_final' => $hoy];
        }

        \Modules\MgEpisodios\Entities\Episodios::where('id', $request->input('id'))
            ->update($data);
        $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
        return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
    }
}
