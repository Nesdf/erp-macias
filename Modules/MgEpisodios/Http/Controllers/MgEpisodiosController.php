<?php

namespace Modules\MgEpisodios\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use \Modules\MgEpisodios\Entities\Episodios;
use \Modules\MgEpisodios\Entities\Proyectos;
use \Modules\MgEpisodios\Entities\Tcr;
use \Modules\MgEpisodios\Entities\Salas;
use \Modules\MgEpisodios\Entities\Users;
use \Modules\MgEpisodios\Entities\TipoReporte;
use Modules\MgPuestos\Entities\Puestos;
use Carbon\Carbon;
use \Modules\MgCatalogoTipoTrabajo\Entities\TiposTrabajo;
use Modules\MgCatalogos\Entities\CatalogoConfiguraciones;
use Modules\MgCatalogos\Entities\EpisodioRelacionConfiguracion;

class MgEpisodiosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {
        try{
            
            $proyecto = Proyectos::find($id);
            $catalogos = CatalogoConfiguraciones::all();
            $proyecto_id = $id;
            $episodios = Episodios::allEpisodioOfProject($id);
            $tcrs = Tcr::All();
            $salas = Salas::All();
            $productores = Users::Productores();
            $responsables = Users::Responsables();
            $directores = Users::Directores();
            $traductores = Users::traductores();
            $reportes = TipoReporte::get();
            $tecnicos = Users::Tecnicos();
            $editores = Puestos::editores();
            $tiposTrabajo = TiposTrabajo::all();
            return view('mgepisodios::episodios', compact('proyecto', 'proyecto_id', 'episodios', 'tcrs', 'salas', 'productores', 'responsables', 'traductores', 'reportes', 'directores', 'tecnicos', 'editores', 'tiposTrabajo', 'catalogos'));

        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return $e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine();
           //return $request->session()->flash('success', trans('Error al cargar los datos, favor de revisar con el administrador'));
        }

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
                    $folio = $this->generateFolio();
                    if(Episodios::searchFolio($folio)){
                        $folio = $this->generateFolio();
                    }

                    //Validar que no se haya capturado el episodio

                    $valida = Episodios::validateEpisodio($request->input('proyectoId'), ucwords( $request->input('num_episodio') ) );

                    if($valida >= 1){
                        return response()->json(['status' =>201, 'type' => 'success', 'msg' => 'Ya se encuentra registrado el episodio.'], 201);
                    }

                    $dataaCreate = Episodios::create([
                        'titulo_original' => ucwords( $request->input('titulo_original_episodio') ),
                        // 'bw' => ($request->input('bw') == 'on') ? true : false ,
                        // 'netcut' => ($request->input('netcut') == 'on') ? true : false ,
                        // 'lockcut' => ($request->input('lockcut') == 'on') ? true : false ,
                        // 'final' => ($request->input('final') == 'on') ? true : false ,
                        // 'date_bw' => ($request->input('bw') == 'on') ? $hoy : null ,
                        // 'date_netcut' => ($request->input('netcut') == 'on') ? $hoy : null ,
                        // 'date_lockcut' => ($request->input('lockcut') == 'on') ? $hoy : null ,
                        // 'date_final' => ($request->input('final') == 'on') ? $hoy : null ,
                        'date_entrega' => $request->input('entrega_episodio') ,
                        'proyectoId' => $request->input('proyectoId'),
                        'configuracion' => $request->input('configuracion'),
                        'num_episodio' => ucwords( $request->input('num_episodio') ),
                        'date_m_and_e' => $request->input('entrega_me'),
                        'productor' => $request->input('productor'),
                        'date_download' => $request->input('fecha_descarga_create') ,
                        'reference_download' => $request->input('referencia'),
                        'las_or_lm' => $request->input('las_or_lm_create'),
                        'bpo_or_lm' => $request->input('bpo_or_lm_create'),
                        'send_sebastians' => ($request->input('envio_sebastians') == 'on') ? true : false,
                        'notify_pistas' => ($request->input('notificacion_pistas') == 'on') ? true : false,
                        'envio_mp4' => $request->input('envio_mp4_create'),
                        'ot' => ($request->input('ot') == 'on') ? true : false,
                        'folio' => $folio,
                        'responsable' => $request->input('responsable'),
                        'material_calificado' => false,
                        'material_entregado' => false,
                        'delete_episodio' => false,
                        'tipo_trabajo_id' => $request->input('tipo_trabajo_create')
                    ]);

                    if($dataaCreate){
                        $dataCatalogos = CatalogoConfiguraciones::pluck('id');
        
                        $dataCatalogosArray = $dataCatalogos->toArray();

                        $dataConfiguracion = [];
                        foreach ($request->all() as $key => $value) {
                            foreach($dataCatalogos as $key2 => $value2){
                                if( $key === $value2){
                                    EpisodioRelacionConfiguracion::create([
                                        'id_episodio' => $dataaCreate->id,
                                        'id_catalogo_configuracion' => $key
                                    ]);
                                }
                            }
                        }
                    }
                    $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
                    return Response(['status' => 200, 'type' => 'success', 'msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }

            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }


    /**
     * Show the specified resource.
     * @return Response
     */
    public function show($id)
    {
        try{

            $episodio =  Episodios::findEpisodio($id);
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
             return Response(['msg' =>'success', 'episodios' => $episodio, 'status_entrega' => $status_entrega], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'error'], 400)->header('Content-Type', 'application/json');
        }

    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        try{
            //return Episodios::find($id);
            $dataRelacion = EpisodioRelacionConfiguracion::select('id','id_episodio', 'id_catalogo_configuracion', 'created_at')
            ->where('id_episodio', $id)
            ->get();

            $dataRelacionAll = Episodios::where('id', $id)
            ->get();

            $data = [
                'data' => $dataRelacionAll,
                'dataClear' => $dataRelacion,
                'listConfig' => CatalogoConfiguraciones::all(),
                'msg' => 'success' 
            ];

            return response()->json($data, 200);
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => $e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine() , 400])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        try{
            if( $request->isMethod('post') && $request->ajax() ){

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
                        Episodios::where('id', $request->input('id'))
                            ->update([
                                'titulo_original' => ucwords( $request->titulo_original_episodio ),
                                'configuracion' => $request->configuracion,
                                'date_entrega' => $request->entrega_episodio,
                                'proyectoId' => $request->proyectoId,
                                'configuracion' => $request->configuracion,
                                'num_episodio' => $request->num_episodio,
                                'date_m_and_e' => $request->entrega_me,
                                'productor' => $request->productor,
                                'date_download' => $request->fecha_descarga_update,
                                'reference_download' => $request->referencia,
                                'send_sebastians' => ($request->envio_sebastians) ? true : false,
                                'notify_pistas' => ($request->notificacion_pistas) ? true : false,
                                'envio_mp4' => $request->input('envio_mp4_update'),
                                'ot' => ($request->ot) ? true : false,
                                'responsable' => $request->responsable,
                                'las_or_lm' => $request->input('las_or_lm_update'),
                                'bpo_or_lm' => $request->input('bpo_or_lm_update'),
                                'tipo_trabajo_id' => $request->input('tipo_trabajo_update'),
                                'enviado_a' => $request->input('enviado_a'),
                                'metodo_envio' => $request->input('metodo_envio'),
                                'referencia_envio' => $request->input('referencia_envio')
                            ]);
                            $request->session()->flash('success', trans('mgpersonal::ui.flash.flash_create_episodio'));
                            return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');

                    } catch(\Exception $e){
                        report($e);
                        return false;
                    }

                }
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'error', 400])->header('Content-Type', 'application/json');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request)
    {
        try{

            if($request->method('post')){
                $episodio  = Episodios::find($request->id);
                $episodio->delete_episodio = true;
                
                if($episodio->save()){
                    \Request::session()->flash('success', 'El episodio se eliminó correctamnete');
                    return redirect('mgepisodios/'.$request->id_proyecto);
                }
            }

            
            // $eliminar = Episodios::destroy($id);
            // if($eliminar){
            //     Episodios::eliminarCalificacion($id);
            // }
            
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    /*public function assignTraductor(Request $request)
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
                    $update = \Modules\MgEpisodios\Entities\Episodios::where('id', $request->input('episodioId'))
                        ->update([
                            'fecha_asignacion_traductor' => $hoy->now(),
                            'fecha_entrega_traductor' => $request->input('fecha_entrega_traductor'),
                            'salaId' => $request->input('sala'),
                            'script' => ( $request->input('script') == 'on') ? true : false,
                            'rayado' => ( $request->input('rayado') == 'on') ? true : false,
                            'traductorId' => $request->input('traductor'),
                            'status_coordinador' => true

                        ]);

                    $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_episodio'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }catch(Exception $e){
                     report($e);
                     return false;
                }
            }
        }
    }*/

    public function updateConfiguration(Request $request)
    {
        try{

            
            // Carbon::today('America/Mexico_City');
            // $hoy = Carbon::now();

            $data = [];

            // if($request->input('bw') == 'on'){
            //     $data = ['bw' => $request->input('bw'), 'date_bw' => $hoy];
            // }
            // if($request->input('netcut') == 'on'){
            //     $data = ['netcut' => $request->input('netcut'), 'date_netcut' => $hoy];
            // }
            // if($request->input('lockcut') == 'on'){
            //     $data = ['lockcut' => $request->input('lockcut'), 'date_lockcut' => $hoy];
            // }
            // if($request->input('final') == 'on'){
            //     $data = ['final' => $request->input('final'), 'date_final' => $hoy];
            // }

            $arrayData = [];
            foreach($request->all() as $key => $val){
                if($key != "_token" && $key != "id"){
                    array_push($arrayData, $key);
                }
            }

            foreach($arrayData as $key2 => $val2){
                EpisodioRelacionConfiguracion::create([
                    'id_episodio' => $request->id,
                    'id_catalogo_configuracion' => $val2
                ]);
            }

            $request->session()->flash('success', trans('mgpersonal::ui.flash.flash_create_episodio'));
            return response()->json(['msg' => 'success'], 200);
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            $error = [
                'status' => 'error',
                'msg' => $e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine()
            ];
            return response()->json($error);
        }
    }

    public function generateFolio()
    {
        try{

            Carbon::today('America/Mexico_City');
            $hoy = Carbon::now();
            $num = explode('-', $hoy->format('d-m-y'));
            $caracteres = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
            $dos='';
            $tres='';
            for($i=0;$i<3;$i++){
                $tres .= strtoupper(substr($caracteres,rand(0,strlen($caracteres)),1));
            }
            for($i=0;$i<2;$i++){
                $dos .= strtoupper(substr($caracteres,rand(0,strlen($caracteres)),1));
            }
            return $dos.'-'.$tres.$num[2].$num[1];
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function addTraductor(Request $request)
    {
        try{

            if($request->isMethod('post') && $request->ajax()){

                $rules = [
                    'traductor' => 'required',
                    'fecha_entrega_traductor' => 'required',
                ];

                $messages = [
                    'traductor.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.traductor')]),
                    'fecha_entrega_traductor.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.fecha_entrega_traductor')]),
                ];


                $validator = \Validator::make($request->all(), $rules, $messages);

                if ( $validator->fails() ) {
                    return Response(['validator' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else{

                    $arrayData = Episodios::where('id', $request->id)->get();

                    Episodios::where('id', $request->id)
                    ->update([
                        'traductorId' => ucwords( $request->traductor ),
                        'fecha_entrega_traductor' => $request->fecha_entrega_traductor,
                        'aprobacion_cliente' => $request->aprobacion_cliente,
                        'fecha_aprobacion_cliente' => $request->fecha_aprobacion_cliente,
                        'sin_script' => ($request->sin_script == 'on') ? true : false ,
                        'rayado' => ($request->rayado == 'on') ? true : false ,
                        'fecha_rayado' => $request->fecha_rayado,
                        'quien_modifico_traductor' => $arrayData[0]->quien_modifico_traductor.','. \Auth::user()->name.' '.\Auth::user()->ap_paterno.' '.\Auth::user()->name,
                        'chk_canciones' => ($request->chk_canciones ? true : false),
                        'chk_subtitulos' => ($request->chk_subtitulos ? true : false),
                        'chk_lenguaje_diferente_original' => ($request->chk_lenguaje_diferente_original ? true : false),
                        'observaciones_traductor' => $request->observaciones_traductor,
                        'script_original' => $request->script_original,
                        'send_date_subtitle_transfer' => $request->fecha_subtitulos_create ? $request->fecha_subtitulos_create : $request->fecha_subtitulo_update
                    ]);
                    $request->session()->flash('success', trans('mgpersonal::ui.flash.flash_create_episodio'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }
            }
        } catch(\Excepton $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' =>  'error', 400])->header('Content-Type', 'application/json');
        }
    }


    public function addProductor(Request $request)
    {
        try{

            if($request->isMethod('post') && $request->ajax()){

                $rules = [
                    'sala' => 'required',
                    'director' => 'required',
                   // 'fecha_doblaje' => 'required',
                ];

                $messages = [
                    'sala.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.sala')]),
                    'director.required' => trans('mgepisodios::ui.display.error_required', ['attribute' => trans('mgepisodios::ui.attribute.director')]),
                ];


                $validator = \Validator::make($request->all(), $rules, $messages);

                if ( $validator->fails() ) {
                    return Response(['validator' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else{

                    $arrayData = Episodios::where('id', $request->input('id'))->get();
                    $data = [
                        'salaId' => ucwords( $request->input('sala') ),
                        'directorId' => $request->input('director'),
                        'fecha_doblaje' => $request->input('fecha_doblaje'),
                        'quien_modifico_productor' => $arrayData[0]->quien_modifico_traductor.','. \Auth::user()->name.' '.\Auth::user()->ap_paterno.' '.\Auth::user()->name,
                        'chk_qc' => ($request->input('chk_qc') ? true : false),
                        'chk_reprobacion' => ($request->input('chk_reprobacion') ? true : false),
                        'chk_edicion' => ($request->input('chk_edicion') ? true : false),
                        'fecha_edicion' => $request->input('fecha_edicion'),
                        'ingeniero_audio_id' => $request->input('ingeniero_audio_id'),
                        'fecha_regrabacion' => ($request->input('fecha_regrabacion') ? $request->input('fecha_regrabacion') : NULL),
                        'nombre_regrabador' => ($request->input('nombre_regrabador') ? $request->input('nombre_regrabador') : NULL),
                        'nombre_editor' => ($request->input('nombre_editor') ? $request->input('nombre_editor') : NULL),
                        'fecha_qc' => ($request->input('fecha_qc') ? $request->input('fecha_qc') : NULL),
                        'nombre_qc' => ($request->input('nombre_qc') ? $request->input('nombre_qc') : NULL)
                    ];

                      if($request->input('fecha_script')){
                        $data['fecha_script'] = $request->input('fecha_script');
                      }

                    Episodios::where('id', $request->input('id'))
                    ->update($data);
                    $request->session()->flash('success', trans('mgpersonal::ui.flash.flash_create_episodio'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }
            }
        } catch(\Excepton $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }

    public function updateCalificarMaterial(Request $request){
        //dd($request->all());
        try {
            //Almacenar datos en episodios
            $actualizarEpisodio = Episodios::find($request->episodio_id);  
            $actualizarEpisodio->sincronia = ($request->sincronia) ? $request->sincronia : '';
            $actualizarEpisodio->editor_id =  ($request->editor) ? $request->editor : 0;
            $actualizarEpisodio->hiss = ($request->hiss) ? $request->hiss : '';
            $actualizarEpisodio->compresion = ($request->compresion) ? $request->compresion : '';
            $actualizarEpisodio->comentarios_observaciones = ($request->comentarios_observaciones) ? $request->comentarios_observaciones : '';
            $actualizarEpisodio->save();


                //Almacenar datos en proyectos
            $actualizarProyecto = Proyectos::find($actualizarEpisodio->proyectoId);  
            $actualizarProyecto->titulo_espanol = ($request->titulo_espaniol_episodio) ? $request->titulo_espaniol_episodio : '';
            $actualizarProyecto->save();
            return redirect('mgepisodios/material-calificado/'.$request->episodio_id .'/'.$actualizarEpisodio->proyectoId);

        } catch(\Excepton $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            //return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
            return "sdfjsd";
        }
    }
}
