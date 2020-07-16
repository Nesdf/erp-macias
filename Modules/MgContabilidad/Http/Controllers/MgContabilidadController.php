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
use Modules\MgContabilidad\Entities\Estudios as Estudios;
use Carbon\Carbon as Carbon;

class MgContabilidadController extends Controller
{
  private  $estudios;
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

      //

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
    public function reporteNominaActores(Request $request) {

        try{

          if(\Auth::user()->lista_estudios == null){
            $estudiosArray = [];
          } else {
            $estudiosArray = explode(',', \Auth::user()->lista_estudios);
          }
            
            $actores = Actores::all();
            //$estudios = Estudios::whereIn('estudio', $estudiosArray);
            $estudiosString  = '';
            for( $i=0; $i<count( $estudiosArray ); $i++ )
            {
              $estudiosString .= ''.$estudiosArray[$i].',';
            }
            $estudiosString = trim($estudiosString, ',');
            //$estudios = Estudios::estudios($estudiosArray);
            $estudios = $estudiosArray;
            if(count($estudiosArray) == 0){
              $request->session()->flash('studios', 'Es necesario que te asignen a un estudio, es por eso que no se muestran en el campo Estudio.');
            }
            return view('mgcontabilidad::reporte-nomina-actores', compact('actores', 'estudios'));
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
            $estudios = Estudios::all();
            return view('mgcontabilidad::reporte-proyectos', compact('proyectos', 'estudios'));
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

            //Permite buscar por estudio
            $this->estudios ;
            if($request->input('estudio_search') == "ALL"){
              $consultaEstudios = Salas::All();
              foreach($consultaEstudios as $value){
                if ($value == end($consultaEstudios)) {
                    $this->estudios .= "'".$value->sala."'";
                } else{
                  $this->estudios .= "'".$value->sala."',";
                }
              }
              $this->estudios = trim($this->estudios, ',');
            } else{
              $consultaEstudios = Salas::searchEstudio($request->input('estudio_search'));
              foreach($consultaEstudios as $value){
                if ($value == end($consultaEstudios)) {
                    $this->estudios .= "'".$value->sala."'";
                } else{
                  $this->estudios .= "'".$value->sala."',";
                }
              }
              $this->estudios = trim($this->estudios, ',');
            }


            $proyectos = Episodios::allEpisodios($lunes->toDateString(), $sabado->toDateString(), $this->estudios);


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

            //Permite buscar por estudio
            $this->estudios = $request->input('estudio_search');
            
            if($request->input('estudio_search') == "ALL"){
              $consultaEstudios = Salas::All();
              foreach($consultaEstudios as $value){
                if ($value == end($consultaEstudios)) {
                    $this->estudios .= "'".$value->sala."'";
                } else{
                  $this->estudios .= "'".$value->sala."',";
                }
              }
              $this->estudios = trim($this->estudios, ',');
            } else{
              $consultaEstudios = Salas::searchEstudio($request->input('estudio_search'));

              $this->estudios = ''; //Limpiar atributo estudios(Hace referencia a las salas de un estudio en específico)
              foreach($consultaEstudios as $value){
                if ($value == end($consultaEstudios)) {
                    $this->estudios .= "'".$value->sala."'";
                } else{
                  $this->estudios .= "'".$value->sala."',";
                }
              }
              $this->estudios = trim($this->estudios, ',');
            }

            
            $allRegister = Llamados::allRegisters($lunes, $sabado->toDateString(), $this->estudios);
            $allIntRegister = Llamados::allIntRegisters($lunes, $sabado->toDateString(), $this->estudios);
            
            $newRegisters = [];

            $int = 0;
            foreach ($allIntRegister as $val) {
                $newRegisters[$int]['nombre_real'] = $val->nombre_real;
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
                if( $newRegisters[$i]['nombre_real'] == $val->nombre_real ){
                  $newRegisters[$i]['credencial'] = $val->credencial;
                  $cita = explode("-", $val->cita_end);
                  //Se vuelve a realizar explode por que el dia se concatena con la hora por un espacio
                  $dia = explode(" ", $cita[2]);
                  $cita_db = Carbon::create($cita[0], $cita[1], $dia[0])->toDateString();
                  //Lunes
                  if($lunes->toDateString() == $cita_db){
                    $newRegisters[$i]['lunes'] += (float)$val->pago_total_loops;
                    //$newRegisters[$i]['lunes'] = number_format($newRegisters[$i]['lunes'], 2);
                    $newRegisters[$i]['lunes'] = $newRegisters[$i]['lunes'];
                  }
                  //Martes
                  if($martes->toDateString() == $cita_db){
                    $newRegisters[$i]['martes'] += (float)$val->pago_total_loops;
                    //--$newRegisters[$i]['martes'] = number_format($newRegisters[$i]['martes'], 2);
                    $newRegisters[$i]['martes'] = $newRegisters[$i]['martes'];
                  }
                  //Miércoles
                  if($miercoles->toDateString() == $cita_db){
                    $newRegisters[$i]['miercoles'] += (float)$val->pago_total_loops;
                    //$newRegisters[$i]['miercoles'] = number_format($newRegisters[$i]['miercoles'], 2);
                    $newRegisters[$i]['miercoles'] = $newRegisters[$i]['miercoles'];
                    
                  }
                  //Jueves
                  if($jueves->toDateString() == $cita_db){
                    $newRegisters[$i]['jueves'] += (float)$val->pago_total_loops;
                    //$newRegisters[$i]['jueves'] = number_format($newRegisters[$i]['jueves'], 2);
                    $newRegisters[$i]['jueves'] = $newRegisters[$i]['jueves'];
                  }
                  //Viernes
                  if($viernes->toDateString() == $cita_db){
                    $newRegisters[$i]['viernes'] += (float)$val->pago_total_loops;
                    //$newRegisters[$i]['viernes'] = number_format($newRegisters[$i]['viernes'], 2);
                    $newRegisters[$i]['viernes'] = $newRegisters[$i]['viernes'];
                  }
                  //Sábado
                  if($sabado->toDateString() == $cita_db){
                    $newRegisters[$i]['sabado'] += (float)$val->pago_total_loops;
                    //$newRegisters[$i]['sabado'] = number_format($newRegisters[$i]['sabado'], 2);
                    $newRegisters[$i]['sabado'] = $newRegisters[$i]['sabado'];
                  }

                }
              }
            }

            for($i=0; $i < count($newRegisters); $i++){
              $newRegisters[$i]['importe'] = (float)$newRegisters[$i]['lunes'] + (float)$newRegisters[$i]['martes'] +(float)$newRegisters[$i]['miercoles'] + (float)$newRegisters[$i]['jueves'] + (float)$newRegisters[$i]['viernes'] +
              + (float)$newRegisters[$i]['sabado'];
              //$newRegisters[$i]['importe'] = money_format($newRegisters[$i]['importe'], 2);
              $newRegisters[$i]['importe'] = $newRegisters[$i]['importe'];
            }
            $total = 0;
            for($i=0; $i < count($newRegisters); $i++){
              $total += (float)$newRegisters[$i]['importe'];
              $total = $total;
            }

            $dataSuccess = [
              "msg" => "success",
              "total" => $total,
              "datos" =>$newRegisters
            ];

            return Response($dataSuccess, 200)->header('Content-Type', 'application/json');
          }

      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());


          $dataError = [
            "status" => "Error",
            "info" => $e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine()
          ];

          return Response($dataError, 200)->header('Content-Type', 'application/json');
      }
    }

    public function detalleEpisodiosActores($folio, $fecha_inicio, $fecha_fin, $estudios)
    {
      try{

        //Permite buscar por estudio
        $this->estudios ;
        if($estudios == "ALL"){
          $consultaEstudios = Salas::All();
          foreach($consultaEstudios as $value){
            if ($value == end($consultaEstudios)) {
                $this->estudios .= "'".$value->sala."'";
            } else{
              $this->estudios .= "'".$value->sala."',";
            }
          }
          $this->estudios = trim($this->estudios, ',');
        } else{
          $consultaEstudios = Salas::searchEstudio($estudios);
          foreach($consultaEstudios as $value){
            if ($value == end($consultaEstudios)) {
                $this->estudios .= "'".$value->sala."'";
            } else{
              $this->estudios .= "'".$value->sala."',";
            }
          }
          $this->estudios = trim($this->estudios, ',');
        }

        $actoresSinEstudio = Llamados::getAllActoresSinEstudio($folio, $fecha_inicio, $fecha_fin);
        $actores = Llamados::getAllActores($folio, $fecha_inicio, $fecha_fin, $this->estudios);
        $dataProyecto = Llamados::getProyecto($actoresSinEstudio[0]->folio);
        if(count($actores) != 0){
          $proyecto = Llamados::getProyecto($actores[0]->folio);
        } else {
          $proyecto = [];
        }

        return view('mgcontabilidad::detalle-episodios-actores', compact('actores','proyecto', 'dataProyecto', 'actoresSinEstudio'));
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
        $estudios = Estudios::all();
        return view('mgcontabilidad::detalle-trabajo-actor', compact('actores', 'estudios'));
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function ajaxDetalleActores(Request $request)
    {
      try{
        if( $request->isMethod('post') && $request->ajax() ){

          //Permite buscar por estudio
          $this->estudios ;
          if($request->input('estudio_search') == "ALL"){
            $consultaEstudios = Salas::All();
            foreach($consultaEstudios as $value){
              if ($value == end($consultaEstudios)) {
                  $this->estudios .= "'".$value->sala."'";
              } else{
                $this->estudios .= "'".$value->sala."',";
              }
            }
            $this->estudios = trim($this->estudios, ',');
          } else{
            $consultaEstudios = Salas::searchEstudio($request->input('estudio_search'));
            foreach($consultaEstudios as $value){
              if ($value == end($consultaEstudios)) {
                  $this->estudios .= "'".$value->sala."'";
              } else{
                $this->estudios .= "'".$value->sala."',";
              }
            }
            $this->estudios = trim($this->estudios, ',');
          }

          $data = Llamados::getTrabajoActores($this->estudios);
          //$allRegister = Llamados::allRegisters($lunes, $sabado->toDateString());

          return Response(['msg'=>'success', 'data'=> $data], 200)->header('Content-Type', 'application/json');
        }
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    /*public function ajaxSearchProyecto($id)
    {
      try{
            $episodios = Episodios::getAllById( $id );

            return Response(['msg'=>'success', 'episodios'=> $episodios, 'code' => 200], 200)->header('Content-Type', 'application/json');
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }*/

    public function ajaxSearchFolios(Request $request)
    {
      try{
            if( $request->isMethod('post') && $request->ajax() ){
              //$llamados = Llamados::getAllActores( $request->input('ajaxEpisodio') );

              $allFolios = Episodios::getAllById($request->input('proyecto_search'));
              //Genera los folios de todos lo espidosio asignados a un proyecto
              $getFolios = '';
              foreach ($allFolios as $value) {
                # code...
                $getFolios .= "'".$value->folio."',";
              }

              $getFolios = trim($getFolios, ',');
              $allLlamados = Llamados::getLlamadosByFolios($getFolios);
              return Response(['msg'=>'success', 'llamados'=> $allLlamados, 'code' => 200], 200)->header('Content-Type', 'application/json');
            }
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function ajaxSearchEpisodio(Request $request)
    {
      try{
            if( $request->isMethod('post') && $request->ajax() ){
              
              $allEpisodios = Episodios::getAllById($request->input('proyecto_search'));

              return Response(['msg'=>'success', 'episodios'=> $allEpisodios, 'code' => 200], 200)->header('Content-Type', 'application/json');
            }
      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function getSearchLlamados($folio, $nombre_episodio)
    {
      try{
          $allLlamados = Llamados::getLlamadosByFolio($folio);

          $nameEpisodio = Episodios::getNameEpisodio($folio);

          return view('mgcontabilidad::get-search-llamados', compact('allLlamados', 'nameEpisodio'));

      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function getSearchNominaActores($lunes, $estudio, $nombre)
    {
      try{
        //Permite buscar por estudio
        $this->estudio = '';
        if($estudio == "ALL"){
          $consultaEstudios = Salas::All();
          foreach($consultaEstudios as $value){
            if ($value == end($consultaEstudios)) {
                $this->estudios .= "'".$value->sala."'";
            } else{
              $this->estudios .= "'".$value->sala."',";
            }
          }
          $this->estudios = trim($this->estudios, ',');
        } else{
          $consultaEstudios = Salas::searchEstudio($estudio);
          foreach($consultaEstudios as $value){
            if ($value == end($consultaEstudios)) {
                $this->estudios .= "'".$value->sala."'";
            } else{
              $this->estudios .= "'".$value->sala."',";
            }
          }
          $this->estudios = trim($this->estudios, ',');
        }
        Carbon::setTestNow($lunes);
        $lunes = new Carbon('this monday');
        $sabado = new Carbon('this saturday');
        Carbon::setTestNow();

          $allLlamados = Llamados::getLlamadosByFechaAndEstudio($lunes, $sabado, $this->estudios, $nombre);

          $nameEpisodio = Episodios::getNameEpisodio($allLlamados[0]->folio);


          return view('mgcontabilidad::get-search-llamados', compact('allLlamados', 'nameEpisodio'));

      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function getDetallePorActor($actor, $estudio)
    {
      try{
          $this->estudio = '';
          if($estudio == "ALL"){
            $consultaEstudios = Salas::All();
            foreach($consultaEstudios as $value){
              if ($value == end($consultaEstudios)) {
                  $this->estudios .= "'".$value->sala."'";
              } else{
                $this->estudios .= "'".$value->sala."',";
              }
            }
            $this->estudios = trim($this->estudios, ',');
          } else{
            $consultaEstudios = Salas::searchEstudio($estudio);
            foreach($consultaEstudios as $value){
              if ($value == end($consultaEstudios)) {
                  $this->estudios .= "'".$value->sala."'";
              } else{
                $this->estudios .= "'".$value->sala."',";
              }
            }
            $this->estudios = trim($this->estudios, ',');
          }

          $llamadoByActor = Llamados::getLlamadosByActor($actor, $this->estudios);
          return view('mgcontabilidad::get-detalle-actor', compact('llamadoByActor'));

      } catch(\Exception $e){
           \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
          \Log::error(' Trace2: ' .$e->getTraceAsString());
      }
    }

    public function ajaxDetalleActoresWeek( Request $request)
    {
      try{
        if( $request->isMethod('post') && $request->ajax() ){

            $lunes = $request->input('lunes');
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
            //->toDateString()

            //Permite buscar por estudio
            $this->estudios ;
            if($request->input('estudio') == "ALL"){
              $consultaEstudios = Salas::All();
              foreach($consultaEstudios as $value){
                if ($value == end($consultaEstudios)) {
                    $this->estudios .= "'".$value->sala."'";
                } else{
                  $this->estudios .= "'".$value->sala."',";
                }
              }
              $this->estudios = trim($this->estudios, ',');
            } else{
              $consultaEstudios = Salas::searchEstudio($request->input('estudio'));
              foreach($consultaEstudios as $value){
                if ($value == end($consultaEstudios)) {
                    $this->estudios .= "'".$value->sala."'";
                } else{
                  $this->estudios .= "'".$value->sala."',";
                }
              }
              $this->estudios = trim($this->estudios, ',');
            }


            $llamados = Llamados::getLlamadosAllActor($lunes->toDateString(), $sabado->toDateString(), $this->estudios);

          return Response(['msg'=>'success', 'llamados'=> $llamados, 'code' => 200], 200)->header('Content-Type', 'application/json');
        }
  } catch(\Exception $e){
       \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
      \Log::error(' Trace2: ' .$e->getTraceAsString());
  }
}

/*public function getSearchLlamados($folio, $nombre_episodio)
{
  try{
      $allLlamados = Llamados::getLlamadosByFolio($folio);

      $nameEpisodio = Episodios::getNameEpisodio($folio);
      return view('mgcontabilidad::get-search-llamados', compact('allLlamados', 'nameEpisodio'));

  } catch(\Exception $e){
       \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
      \Log::error(' Trace2: ' .$e->getTraceAsString());
  }
    }*/
}
