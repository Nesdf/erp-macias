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
use \Modules\MgCalendar\Entities\Tabulador as Tabulador;
use \Modules\MgCalendar\Entities\User as User;
use App\Globals\Config;

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
            //$actores_personajes = ActorPersonaje::get();
            return view('mgcalendar::llamados', compact('estudios', 'proyectos', 'actores'));
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

                $dir = User::find($folio->directorId);
                $director = $dir->name.' '.$dir->ap_paterno.' '.$dir->ap_materno;
                $data_estudios = Estudios::find($salas[0]->estudio_id);
            }

            return Response(['msg' => $salas, 'estudio'=>$data_estudios->estudio, 'llamados', $llamados, 'folio' => $folio->folio, 'capitulo' => $folio->num_episodio, 'director' => $director], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }


    public function calendarSalas()
    {
        try{

            $actores = Actores::get();
            return Response(['msg' => 'menasje', 'actores' => $actores], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function listEpisodios($id)
    {
        try{

            $episodios = Episodios::listEpisodios($id);
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
                $meses = ['01'=>'01', '02'=>'02', '03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'8','09'=>'09','10'=>'10', '11'=>'11', '12'=>'12'];
                $date = explode('-', $request->input('dia'));
                
                $dt = Carbon::now();
                $cita_entrada = $dt->year($date[0])->month($meses[$date[1]])->day($date[2])->hour($request->input('hora_entrada'))->minute($request->input('min_entrada'))->second(00)->toDateTimeString();

                $cita_salida = $dt->year($date[0])->month($meses[$date[1]])->day($date[2])->hour($request->input('hora_salida'))->minute($request->input('min_salida'))->second(00)->toDateTimeString();
                $fecha_salida = $date[0].'-'.$meses[$date[1]].'-'.$date[2];
                //Valida si en éste día se tiene llamado en otra sala
                $hora_entrada = $request->input('hora_entrada').':'.$request->input('min_entrada').':00';
                $hora_salida = $request->input('hora_salida').':'.$request->input('min_salida').':00';

                $existeLlamadoHoy = Llamados::existeLlamadoHoy( $request->input('actor') , $request->input('sala'), $fecha_salida, $hora_entrada, $hora_salida );

                if( count($existeLlamadoHoy) > 0){
                    return Response(['error' => $request->input('actor') . ' ya tiene llamado en la sala ' . $existeLlamadoHoy[0]->sala, 'code' => 401], 400)->header('Content-Type', 'application/json');
                }

                //Validar fecha y hora disponible
                $searchFecha = Llamados::EntreFechas($cita_entrada, $cita_salida, $request->input('sala'));

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

                        $request->session()->put('key', 'value');
                    }

                }
                // verifica en el tabulador el pago por loops
                $pago_total_loops = Tabulador::getTabulador((int)$request->input('loops'));

                setlocale(LC_MONETARY, 'en_US.UTF-8');

                Llamados::create([
                    'actor' => $request->input('actor'),
                    'director' => $request->input('director'),
                    'cita_start' => $cita_entrada,
                    'cita_end' => $cita_salida,
                    'folio' => $request->input('folio'),
                    'capitulo' => $request->input('capitulo'),
                    'credencial' => $request->input('credencial'),
                    'loops' => $request->input('loops'),
                    'pago_total_loops' => round($pago_total_loops[0]->tabulador,2),
                    'estatus_llamado' => Config::RTK,
                    'sala' => $request->input('sala'),
                    'estatus_pago' => 'No Pagado',
                    'nombre_real' => $request->input('nombre_real'),
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
        $salas = Salas::get();
        return view('mgcalendar::list-llamados', compact('salas'));
    }

    public function searchLlamados(Request $request){

        try{
            if( $request->isMethod('post') && $request->ajax() ){
                $llamados = Llamados::allLlamados($request->input('search_sala'), $request->input('search_fecha'));
                $allFolios = [];
                foreach ($llamados as $key => $value) {

                    #$allFolios[] = $value->folio;
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

            $credenciales = Actores::credencialesActores($id);
            $nombre_real = Actores::nombreReal($id);
            return Response(['credenciales' => $credenciales, 'nombre_real' => $nombre_real[0]], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function editLlamado($id)
    {
        try{

            $llamado = Actores::find($id);
            return Response(['llamado' => $llamado], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function deleteLlamado($id)
    {
        try{

            if(Llamados::eliminarLlamado($id)){
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

                Llamados::allLlamados($request->input());
            }

        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'Verificar con el administrador']);
        }
    }

    public function reagendarLlamado()
    {
      try{
        $actores = Actores::All();
        return view('mgcalendar::reagendar-llamado', compact('actores'));

      } catch(\Exception $e){
          \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
          return Response(['error' => 'Verificar con el administrador']);
      }
    }

    public function searchReagendarLlamado(Request $request)
    {
      try{
        if( $request->isMethod('post') && $request->ajax() ){

          $lista_llamados = Llamados::getLlamados($request->input('search_actor'), $request->input('search_fecha'));
          return Response(['msg' => $lista_llamados,'status' => 'success' ], 200)->header('Content-Type', 'application/json');
        }

      } catch(\Exception $e){
          \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
          return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
      }
    }

    public function saveReagendarLlamado(Request $request)
    {
      try{
        if( $request->isMethod('post') ){

          $llamado = Llamados::find($request->input('id'));

          $data = Llamados::where('id', $request->input('id'))
            ->update([
              'estatus_llamado' => Config::REAGENDAR
            ]);

            if($data){
              Llamados::create([
                  'actor' => $llamado->actor,
                  'cita_start' => $request->input('new_date').', '.$request->input('hora_entrada').':'.$request->input('min_entrada').':00',
                  'folio' => $llamado->folio,
                  'cita_end' => $request->input('new_date').' '.$request->input('hora_salida').':'.$request->input('min_salida').':00',
                  'estatus_grupo' => $llamado->estatus_grupo,
                  'estatus' => $llamado->estatus,
                  'descripcion' => $llamado->descripcion,
                  'director' => $llamado->director,
                  'sala' => $llamado->sala,
                  'credencial' => $llamado->credencial,
                  'loops' => $llamado->loops,
                  'capitulo' => $llamado->capitulo,
                  'pago_total_loops' => $llamado->pago_total_loops,
                  'estatus_llamado' => Config::RTK,
                  'descripcion_reagenda' => $request->input('descripcion_reagenda'),
                  'estatus_reagenda' => true,
                  'id_llamado_reagendado' => $request->input('id')
                ]);
            }


          $request->session()->flash('success', 'Se Re-agendó con éxito.');
          $actores = Actores::All();
          return view('mgcalendar::reagendar-llamado', compact('actores'));
        }

      } catch(\Exception $e){
          \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
          return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
      }
    }

    public function ajaxGetPersonajes(){
      try{
        $actores_personajes = ActorPersonaje::get();
        return Response(['msg' => 'success', 'actores' => $actores_personajes, 'pagos' => $actores_personajes ], 200)->header('Content-Type', 'application/json');
      } catch(\Exception $e){
          \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
          return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
          //
      }
    }

    public function viewCrearLlamado(){
      try{
        $proyectos = Proyectos::get();
        $estudios = Estudios::get();
        $actores = Actores::get();
        return view('mgcalendar::view-crear-llamado', compact('estudios', 'proyectos', 'actores'));
      } catch(\Exception $e){
          \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
          return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
          //
      }
    }
    
}
