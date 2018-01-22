<?php

namespace Modules\MgCalendar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
use \Modules\MgCalendar\Entities\Proyectos as Proyectos;
use \Modules\MgCalendar\Entities\Estudios as Estudios;
use \Modules\MgCalendar\Entities\Actores as Actores;
use \Modules\MgCalendar\Entities\ActorPersonaje as ActorPersonaje;
use \Modules\MgCalendar\Entities\Llamados as Llamados;
use \Modules\MgCalendar\Entities\Episodios as Episodios;
use \Modules\MgCalendar\Entities\Salas as Salas;

class MgCalendarController extends Controller
{
    public $data_table;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try{

            $proyectos = Proyectos::get();
            $estudios = Estudios::get();
            $actores = Actores::get();
            $actores_personajes = ActorPersonaje::get();
            return view('mgcalendar::index', compact('estudios', 'proyectos', 'actores', 'actores_personajes'));
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
        return view('mgcalendar::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgcalendar::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgcalendar::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function listSalas($id, $id_episodio)
    {
        try{

            $salas = Salas::listSalas($id);
            $llamados = Llamados::listaLlamados($salas[0]->sala);
            $folio = Episodios::find($id_episodio);

            if($folio->directorId == null){
                $director = "No se ha seleccionador director";
            } else{

                $dir = \Modules\MgCalendar\Entities\User::find($folio->directorId);
                $director = $dir->name.' '.$dir->ap_paterno.' '.$dir->ap_materno;
            }

            return Response(['msg' => $salas, 'llamados', $llamados, 'folio' => $folio->folio, 'capitulo' => $folio->num_episodio, 'director' => $director], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }


    public function calendarSalas()
    {
        try{

            $actores = \Modules\MgCalendar\Entities\Actores::get();
            return Response(['msg' => 'menasje', 'actores' => $actores], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function listEpisodios($id)
    {
        try{

            $episodios = \Modules\MgCalendar\Entities\Episodios::listEpisodios($id);
            return Response(['msg' => $episodios], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => $episodios], 400)->header('Content-Type', 'application/json');
        }
        
    }

    public function citaLlamado(Request $request)
    {
        try{
            if($request->isMethod('post') && $request->ajax()){
                
                $meses = ['Jan'=>'01', 'Feb'=>'02', 'Mar'=>'03','Apr'=>'04','May'=>'05','Jun'=>'06','Jul'=>'07','Aug'=>'8','Sep'=>'09','Oct'=>'10', 'Nov'=>'11', 'Dec'=>'12'];
                $date = explode(' ', $request->input('dia'));
                $dt = Carbon::now();
                $cita_entrada = $dt->year($date[3])->month($meses[$date[1]])->day($date[2])->hour($request->input('hora_entrada'))->minute($request->input('min_entrada'))->second(00)->toDateTimeString();

                $cita_salida = $dt->year($date[3])->month($meses[$date[1]])->day($date[2])->hour($request->input('hora_salida'))->minute($request->input('min_salida'))->second(00)->toDateTimeString(); 
                //Validar fecha y hora disponible
                
                $searchFecha = \Modules\MgCalendar\Entities\Llamados::EntreFechas($cita_entrada, $cita_salida, $request->input('sala'));
                
                if($request->input('estatus_grupo') != 'on'){
                    if( count($searchFecha) > 0){
                       
                        return Response(['error' => 'Ya existe un registro en este horario'], 404)->header('Content-Type', 'application/json');
                    } 
                }
                //Termina validación de fecha disponible

                $existe = ActorPersonaje::getExiste(ucwords( strtolower( $request->input('nuevo_personaje') ) ), $request->input('episodio_folio'));

                if(!$existe){

                    if($request->input('nuevo_personaje')){

                        ActorPersonaje::create([      
                            'personaje' => ucwords( strtolower( $request->input('nuevo_personaje') ) ),
                            'episodio_folio' => $request->input('episodio_folio'),
                            'fijo' => ($request->input('fijo') == 'on') ? true : false,
                            'proyecto' => ($request->input('proyecto') == 'on') ? true : false
                        ]);
                    }

                }

                
                Llamados::create([      
                    'actor' => $request->input('actor'),
                    'director' => $request->input('director'),
                    'cita_start' => $cita_entrada,
                    'cita_end' => $cita_salida,
                    'folio' => $request->input('folio'),
                    'capitulo' => $request->input('capitulo'),
                    'credencial' => $request->input('credencial'),
                    'loops' => $request->input('loops'),
                    'sala' => $request->input('sala'),
                    //'descripcion' => $request->input('personaje'),
                    'descripcion' => ($request->input('nuevo_personaje')) ? ucwords( strtolower( $request->input('nuevo_personaje') ) ) : ucwords( strtolower( $request->input('personaje') ) ),
                    'estatus_grupo' => ($request->input('estatus_grupo') == 'on') ? true : false,
                    'estatus' => true
                ]);



                //$request->session()->flash('message', trans('mgcalendar::ui.flash.flash_create_llamdo'));
                return Response(['msg' => 'success', 'actor'=>$request->input('actor'), 'start'=>$cita_entrada, 'end'=>$cita_salida], 200)->header('Content-Type', 'application/json');
            }

        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
        }
    }

    public function listLlamados(){
        $salas = \Modules\MgCalendar\Entities\Salas::get();
        return view('mgcalendar::list-llamados', compact('salas'));
    }

    public function searchLlamados(Request $request){

        try{
            if( $request->method('post') && $request->ajax() ){
                $llamados = Llamados::allLlamados($request->input('search_sala'), $request->input('search_fecha'));
                $allFolios = [];
                foreach ($llamados as $key => $value) {
                    
                    $allFolios[] = $value->folio;
                }
                $proyectos = Proyectos::allProyects($allFolios);

                return Response(['msg' => 'success', 'llamados' => $llamados, 'proyectos' => $proyectos], 200)->header('Content-Type', 'application/json');
            }

        } catch(\Exception $e){
            return Response(['error' => $e->getMessage()], 402)->header('Content-Type', 'application/json');
        }
    }

    public function credencialesActores($id)
    {
        try{

            $credenciales = \Modules\MgCalendar\Entities\Actores::credencialesActores($id);
            return Response(['credenciales' => $credenciales], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        } 
    }

    public function editLlamado($id)
    {
        try{

            $llamado = \Modules\MgCalendar\Entities\Actores::find($id);
            return Response(['llamado' => $llamado], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function deleteLlamado($id)
    {
        try{

            if(\Modules\MgCalendar\Entities\Llamados::destroy($id)){
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
        }        
    }

    public function pdfLlamados(Request $request)
    {

        try{
            if( $request->isMethod('post') ){
                
                $array_multiselect = explode(',', $request->input('headers'));
                $explode_data = substr($request->input('data'), 3);
                $llamados = Llamados::allLlamados($request->input('sala'), $request->input('fecha'));
                $allFolios = [];
                foreach ($llamados as $key => $value) {
                    $allFolios[] = $value->folio;
                }
                $listFecha = explode('-', $request->input('fecha'));
                $fecha = $listFecha[2].'-'.$listFecha[1].'-'.$listFecha[0]; 
                $proyectos = Proyectos::allProyects($allFolios);
                $sala = $request->input('sala');
                $estudio = $llamados[0]->estudio;
                $director = $llamados[0]->director;
                
                $pdf = \PDF::loadView('mgcalendar::list-llamados-pdf', compact('explode_data', 'array_multiselect', 'director', 'estudio', 'proyectos', 'sala', 'fecha'))->setPaper('a4', 'landscape');
                return $pdf->stream('exito');
            }

        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }        
        //return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
    }

    public function LlamadoActor(Request $request)
    {
        try{
            dd($request->all());
            if($request->isMethod('post') && $request->ajax()){

                \Modules\MgCalendar\Entities\Llamados::allLlamados($request->input());
            }

        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'Verificar con el administrador']);
        }
    }
}
