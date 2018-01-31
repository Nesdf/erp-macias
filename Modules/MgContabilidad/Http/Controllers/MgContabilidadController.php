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

            $proyectos = Episodios::allEpisodios($request->input('fecha_inicial_search'), $request->input('fecha_final_search'));

            return Response(['msg'=>'success', 'proyectos' => $proyectos], 200)->header('Content-Type', 'application/json');
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function ajaxNominaActores(Request $request)
    {
      try{
          if( $request->isMethod('post') && $request->ajax() ) {
            $data = Proyectos::all();

            return Response(['msg'=>'success', 'proyectos' => $data], 200)->header('Content-Type', 'application/json');
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
}
