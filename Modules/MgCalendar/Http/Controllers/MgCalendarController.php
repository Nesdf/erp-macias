<?php

namespace Modules\MgCalendar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class MgCalendarController extends Controller
{
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

    public function listSalas($id)
    {
        $salas = \Modules\MgCalendar\Entities\Salas::listSalas($id);        
        $llamados = \Modules\MgCalendar\Entities\Llamados::listaLlamados();
        return Response(['msg' => $salas, 'llamados', $llamados], 200)->header('Content-Type', 'application/json');
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
            if($request->method('post') && $request->ajax()){

                $meses = ['Aug'=>'8','Sep'=>'09','Oct'=>'10'];
                $date = explode(' ', $request->input('dia'));
                $hora_entrada = explode(':', $request->input('entrada'));
                $hora_salida = explode(':', $request->input('salida'));

                $dt = Carbon::now();
                $cita_entrada = $dt->year($date[3])->month($meses[$date[1]])->day($date[2])->hour($hora_entrada[0])->minute($hora_entrada[1])->second(00)->toDateTimeString();
                $cita_salida = $dt->year($date[3])->month($meses[$date[1]])->day($date[2])->hour($hora_salida[0])->minute($hora_salida[1])->second(00)->toDateTimeString(); 
                
                \Modules\MgCalendar\Entities\Llamados::create([      
                    'actor' => $request->input('actor'),
                    'director' => $request->input('director'),
                    'cita_start' => $cita_entrada,
                    'cita_end' => $cita_salida,
                    'folio' => 'folio',
                    'descripcion' => ($request->input('final') == 'on') ? true : false ,
                    'estatus_grupo' => ($request->input('bw') == 'on') ? true : false,
                    'estatus' => true
                ]);
                $request->session()->flash('message', trans('mgcalendar::ui.flash.flash_create_llamdo'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }

        } catch(\Exception $e){
            return "Error: " . $e;
        }
    }
}
