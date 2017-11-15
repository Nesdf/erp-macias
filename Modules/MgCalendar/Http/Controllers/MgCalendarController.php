<?php

namespace Modules\MgCalendar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class MgCalendarController extends Controller
{
    public $data_table;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $proyectos = \Modules\MgCalendar\Entities\Proyectos::get();
        $estudios = \Modules\MgCalendar\Entities\Estudios::get();
        $actores = \Modules\MgCalendar\Entities\Actores::get();
        $directores = \Modules\MgCalendar\Entities\Actores::Directores();
        return view('mgcalendar::index', compact('estudios', 'proyectos', 'actores', 'directores'));
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
        $salas = \Modules\MgCalendar\Entities\Salas::listSalas($id);
        $llamados = \Modules\MgCalendar\Entities\Llamados::listaLlamados($salas[0]->sala);
        $folio = \Modules\MgCalendar\Entities\Episodios::find($id_episodio);
        return Response(['msg' => $salas, 'llamados', $llamados, 'folio' => $folio->folio, 'capitulo' => $folio->num_episodio], 200)->header('Content-Type', 'application/json');
    }


    public function calendarSalas()
    {
        $actores = \Modules\MgCalendar\Entities\Actores::get();
        return Response(['msg' => 'menasje', 'actores' => $actores], 200)->header('Content-Type', 'application/json');
    }

    public function listEpisodios($id)
    {
        $episodios = \Modules\MgCalendar\Entities\Episodios::listEpisodios($id);
        return Response(['msg' => $episodios], 200)->header('Content-Type', 'application/json');
    }

    public function citaLlamado(Request $request)
    {
        try{
            if($request->isMethod('post') && $request->ajax()){

                //dd($request->all());
                $meses = ['Ene'=>'01', 'Feb'=>'02', 'Mar'=>'03','Abr'=>'04','May'=>'05','Jun'=>'06','Jul'=>'07','Aug'=>'8','Sep'=>'09','Oct'=>'10', 'Nov'=>'11', 'Dic'=>'12'];
                $date = explode(' ', $request->input('dia'));
                $hora_entrada = explode(':', $request->input('entrada'));
                $hora_salida = explode(':', $request->input('salida'));

                $dt = Carbon::now();
                $cita_entrada = $dt->year($date[3])->month($meses[$date[1]])->day($date[2])->hour($hora_entrada[0])->minute($hora_entrada[1])->second(00)->toDateTimeString();
                $cita_salida = $dt->year($date[3])->month($meses[$date[1]])->day($date[2])->hour($hora_salida[0])->minute($hora_salida[1])->second(00)->toDateTimeString(); 
                //Validar fecha y hora disponible
                
                $searchFecha = \Modules\MgCalendar\Entities\Llamados::EntreFechas($cita_entrada, $cita_salida, $request->input('sala'));

                if($request->input('estatus_grupo') != 'on'){
                    if( count($searchFecha) > 0){
                        return Response(['msg' => 'error'], 404)->header('Content-Type', 'application/json');
                    } 
                }
                //Termina validación de fecha disponible

                
                \Modules\MgCalendar\Entities\Llamados::create([      
                    'actor' => $request->input('actor'),
                    'director' => $request->input('director'),
                    'cita_start' => $cita_entrada,
                    'cita_end' => $cita_salida,
                    'folio' => $request->input('folio'),
                    'capitulo' => $request->input('capitulo'),
                    'credencial' => $request->input('credencial'),
                    'loops' => $request->input('loops'),
                    'sala' => $request->input('sala'),
                    'descripcion' => $request->input('descripcion') ,
                    'estatus_grupo' => ($request->input('estatus_grupo') == 'on') ? true : false,
                    'estatus' => true
                ]);



                //$request->session()->flash('message', trans('mgcalendar::ui.flash.flash_create_llamdo'));
                return Response(['msg' => 'success', 'actor'=>$request->input('actor'), 'start'=>$cita_entrada, 'end'=>$cita_salida], 200)->header('Content-Type', 'application/json');
            }

        } catch(\Exception $e){
            return "Error: " . $e->getMessage();
        }
    }

    public function listLlamados(){
        $salas = \Modules\MgCalendar\Entities\Salas::get();
        return view('mgcalendar::list-llamados', compact('salas'));
    }

    public function searchLlamados(Request $request){

        try{
            if( $request->method('post') && $request->ajax() ){
                $llamados = \Modules\MgCalendar\Entities\Llamados::allLlamados($request->input('search_sala'), $request->input('search_fecha'));
                $allFolios = [];
                foreach ($llamados as $key => $value) {
                    # code...
                    $allFolios[] = $value->folio;
                }
                $proyectos = \Modules\MgCalendar\Entities\Proyectos::allProyects($allFolios);
                return Response(['llamados' => $llamados, 'proyectos' => $proyectos], 200)->header('Content-Type', 'application/json');
            }

        } catch(\Exception $e){
            return Response(['msg' => $e->getMessage()], 402)->header('Content-Type', 'application/json');
        }
    }

    public function credencialesActores($id)
    {
        $credenciales = \Modules\MgCalendar\Entities\Actores::credencialesActores($id);
        return Response(['credenciales' => $credenciales], 200)->header('Content-Type', 'application/json');
    }

    public function editLlamado($id)
    {
        $llamado = \Modules\MgCalendar\Entities\Actores::find($id);
        return Response(['llamado' => $llamado], 200)->header('Content-Type', 'application/json');
    }

    public function deleteLlamado($id)
    {
        if(\Modules\MgCalendar\Entities\Llamados::destroy($id)){
            return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
        }
        
    }

    public function pdfLlamados(Request $request)
    {

        try{
            if( $request->method('post') ){
                $array_multiselect = explode(',', $request->input('headers'));
                $explode_data = $request->input('data');
                $llamados = \Modules\MgCalendar\Entities\Llamados::allLlamados($request->input('sala'), $request->input('fecha'));
                $allFolios = [];
                foreach ($llamados as $key => $value) {
                    # code...
                    $allFolios[] = $value->folio;
                }
                $listFecha = explode('-', $request->input('fecha'));
                $fecha = $listFecha[2].'-'.$listFecha[1].'-'.$listFecha[0]; 
                $proyectos = \Modules\MgCalendar\Entities\Proyectos::allProyects($allFolios);
                
                $pdf = \PDF::loadView('mgcalendar::list-llamados-pdf', compact('explode_data', 'array_multiselect', 'proyectos', 'fecha'))->setPaper('a4', 'landscape');
                return $pdf->stream('exito');
            }

        } catch(\Exception $e){
            return $e->getMessage();
        }        
        //return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
    }
}
