<?php

namespace Modules\MgContabilidad\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgContabilidad\Entities\Salas as Salas;
use Modules\MgContabilidad\Entities\Actores as Actores;
use Modules\MgContabilidad\Entities\Episodios as Episodios;
use Modules\MgContabilidad\Entities\Proyectos as Proyectos;
use Modules\MgContabilidad\Entities\Llamados as Llamados;
use Carbon\Carbon as Carbon;

class MgContabilidadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('mgcontabilidad::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgcontabilidad::create');
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
        return view('mgcontabilidad::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgcontabilidad::edit');
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

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reporteGeneral() {

        try{
            $episodios = Episodios::All();
            return view('mgcontabilidad::reporte-general', compact('episodios'));
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reporteLlamadoActores() {

        try{
            $salas = Salas::salasAll();
            return view('mgcontabilidad::reporte-llamado-actores', compact('salas'));
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function ajaxLlamadoActores(Request $request) {
        try{
          if( $request->isMethod('post') && $request->ajax() ){

            $llamados = Llamados::allLlamados($request->input('sala'), $request->input('fecha_search'));
            //return Response(['msg' => $llamados], 200)->header('Content-Type', 'application/json');
            $allFolios = [];
            foreach ($llamados as $key => $value) {

                $allFolios[] = $value->folio;
            }
            $proyectos = Proyectos::allProyects($allFolios);

            return Response(['msg' => 'success', 'llamados' => $llamados, 'proyectos' => $proyectos], 200)->header('Content-Type', 'application/json');
          }
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
            return Response(['error' => 'error'], 400)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reporteNominaActores() {

        try{
            $actores = Actores::all();
            return view('mgcontabilidad::reporte-nomina-actores', compact('actores'));
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reporteProyectos() {

        try{
            $proyectos = Proyectos::all();
            return view('mgcontabilidad::reporte-proyecto', compact('proyectos'));
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function reporteEpisodio() {

        try{
            $episodios = Episodios::all();
            return view('mgcontabilidad::reporte-episodio', compact('episodios'));
        } catch(\Exception $e) {
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function ajaxReporteGeneral() {
        try{

            return Response(['success' => $data], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function ajaxReporteEpisodios() {
        try{

            $data = Episodios::all();

            return Response(['msg'=>'success', 'episodios' => $data], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function ajaxReporteProyectos(Request $request) {
        try{

            //$proyectos = Episodios::allEpisodios($request->input('fecha_inicial_search'), $request->input('fecha_final_search'));
            $lunes = $request->input('lunes_search');
            $fechaArray = explode("-", $lunes);
            $date = Carbon::create($fechaArray[0], $fechaArray[1], $fechaArray[2])->toDateString();
            Carbon::setTestNow($date);
            $lunes = new Carbon('this monday');
            $sabado = new Carbon('this saturday');
            Carbon::setTestNow();
            $proyectos = Episodios::allEpisodios($lunes->toDateString(), $sabado->toDateString());


            return Response(['msg'=>'success', 'proyectos' => $proyectos, 'lunes' => $lunes->toDateString(), 'sabado' => $sabado->toDateString()], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function ajaxNominaActores(Request $request)
    {
      try{
          if( $request->isMethod('post') && $request->ajax() ) {

            $lunes = $request->input('lunes_search');
            $fechaArray = explode("-", $lunes);
            $date = Carbon::create($fechaArray[0], $fechaArray[1], $fechaArray[2])->toDateString();
            //Seleccionar fecha por día
            Carbon::setTestNow($date);
            $lunes = new Carbon('this monday');
            $martes = new Carbon('this tuesday');
            $miercoles = new Carbon('this wednesday');
            $jueves = new Carbon('this thursday');
            $viernes = new Carbon('this friday');
            $sabado = new Carbon('this saturday');
            Carbon::setTestNow();

            $allRegister = Llamados::allRegisters($lunes, $sabado->toDateString());
            $allIntRegister = Llamados::allIntRegisters($lunes, $sabado->toDateString());

            $newRegisters = [];

            $int = 0;
            foreach ($allIntRegister as $val) {
                $newRegisters[$int]['actor'] = $val->actor;
                $newRegisters[$int]['credencial'] = "";
                $newRegisters[$int]['lunes'] = 0;
                $newRegisters[$int]['martes'] = 0;
                $newRegisters[$int]['miercoles'] = 0;
                $newRegisters[$int]['jueves'] = 0;
                $newRegisters[$int]['viernes'] = 0;
                $newRegisters[$int]['sabado'] = 0;
                $int++;
            }
            for($i=0; $i < count($allIntRegister); $i++){
              foreach($allRegister as $val){
                if( $newRegisters[$i]['actor'] == $val->actor ){
                  $newRegisters[$i]['credencial'] = $val->credencial;
                  $cita = explode("-", $val->cita_end);
                  //Se vuelve a realizar explode por que el dia se concatena con la hora por un espacio
                  $dia = explode(" ", $cita[2]);
                  $cita_db = Carbon::create($cita[0], $cita[1], $dia[0])->toDateString();
                  //Lunes
                  if($lunes->toDateString() == $cita_db){
                    $newRegisters[$i]['lunes'] += (float)$val->pago_total_loops;
                    $newRegisters[$i]['lunes'] = money_format($newRegisters[$i]['lunes'], 2);
                  }
                  //Martes
                  if($martes->toDateString() == $cita_db){
                    $newRegisters[$i]['martes'] += (float)$val->pago_total_loops;
                    $newRegisters[$i]['martes'] = money_format($newRegisters[$i]['martes'], 2);
                  }
                  //Miércoles
                  if($miercoles->toDateString() == $cita_db){
                    $newRegisters[$i]['miercoles'] += (float)$val->pago_total_loops;
                    $newRegisters[$i]['miercoles'] = money_format($newRegisters[$i]['miercoles'], 2);
                  }
                  //Jueves
                  if($jueves->toDateString() == $cita_db){
                    $newRegisters[$i]['jueves'] += (float)$val->pago_total_loops;
                    $newRegisters[$i]['jueves'] = money_format($newRegisters[$i]['jueves'], 2);
                  }
                  //Viernes
                  if($viernes->toDateString() == $cita_db){
                    $newRegisters[$i]['viernes'] += (float)$val->pago_total_loops;
                    $newRegisters[$i]['viernes'] = money_format($newRegisters[$i]['viernes'], 2);
                  }
                  //Sábado
                  if($sabado->toDateString() == $cita_db){
                    $newRegisters[$i]['sabado'] += (float)$val->pago_total_loops;
                    $newRegisters[$i]['sabado'] = money_format($newRegisters[$i]['sabado'], 2);
                  }

                }
              }
            }

            for($i=0; $i < count($newRegisters); $i++){
              $newRegisters[$i]['importe'] = (float)$newRegisters[$i]['lunes'] + (float)$newRegisters[$i]['martes'] +(float)$newRegisters[$i]['miercoles'] + (float)$newRegisters[$i]['jueves'] + (float)$newRegisters[$i]['viernes'] +
              + (float)$newRegisters[$i]['sabado'];
              $newRegisters[$i]['importe'] = money_format($newRegisters[$i]['importe'], 2);
            }
            $total = 0;
            for($i=0; $i < count($newRegisters); $i++){
              $total += (float)$newRegisters[$i]['importe'];
              $total = money_format($total,2);
            }

            return Response(['msg'=>'success', 'total'=> $total, 'datos'=>$newRegisters], 200)->header('Content-Type', 'application/json');
          }

      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function detalleEpisodiosActores($folio, $fecha_inicio, $fecha_fin)
    {
      try{

        $actores = Llamados::getAllActores($folio, $fecha_inicio, $fecha_fin);
        return view('mgcontabilidad::detalle-episodios-actores', compact('actores'));
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function reporteTrabajoActor()
    {
      try{

        $actores = Llamados::getAllActores($folio, $fecha_inicio, $fecha_fin);
        return view('mgcontabilidad::detalle-trabajo-actor', compact('actores'));
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function detallePorActor(){
      try{
        $actores = Actores::all();
        return view('mgcontabilidad::detalle-trabajo-actor', compact('actores'));
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function ajaxDetalleActores(Request $request)
    {
      try{
        if( $request->isMethod('post') && $request->ajax() ){


          $data = Llamados::getDetalleActores($request->input('inicial_search'), $request->input('final_search'));
          //$allRegister = Llamados::allRegisters($lunes, $sabado->toDateString());

          return Response(['msg'=>'success', 'data'=> $data], 200)->header('Content-Type', 'application/json');
        }
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }
}
