<?php

namespace Modules\MgContabilidad\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Storage;
use File;
use Illuminate\Support\Facades\Mail;
use Modules\MgContabilidad\Emails\PagosEmail as PagosEmail;
use Modules\MgContabilidad\Entities\Salas as Salas;
use Modules\MgContabilidad\Entities\Actores as Actores;
use Modules\MgContabilidad\Entities\Episodios as Episodios;
use Modules\MgContabilidad\Entities\Proyectos as Proyectos;
use Modules\MgContabilidad\Entities\Llamados as Llamados;
use Modules\MgContabilidad\Entities\Estudios as Estudios;

class MgPagosController extends Controller
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
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function getPagosActores( Request $request )
    {
        try{
            $actores = Llamados::getLlamadosOnlyActor( $request->input('actor_search') );
            return Response(['msg'=>'success', 'actores'=> $actores, 'code' => 200], 200)->header('Content-Type', 'application/json');
      
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function getAllActoresPagos()
    {
        try{
            $actores = Actores::all();
            return view('mgcontabilidad::pagos.add-pagos-actores', compact('actores'));
      
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function showPagosActores()
    {
        try{
            $actores = Actores::all();
            return view('mgcontabilidad::pagos.show-pagos-actores', compact('actores'));
      
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
      
        }
    }

    public function sendEmailPagos( Request $request )
    {
        try{
            Mail::to('nes64df@gmail.com', 'Prueba de correo')
            ->send(new PagosEmail($request->input('data'), $request->input('pago')));
            
            foreach ($request->input('data') as $key => $value) {
                # code...
                Llamados::where('id', $key)->update([               
                    'estatus_pago' => 'Correo Enviado'
                ]);
            }
                
             return Response(['msg'=>'success', 'data'=> $request->input('data'), 'code' => 200], 200)->header('Content-Type', 'application/json');
      
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function saveFilesPagos( Request $request )
    {
        try{
            //obtenemos el campo file definido en el formulario
            //$xml = $request->file('xml');
            //$pdf = $request->file('pdf');

            //indicamos que queremos guardar un nuevo archivo en el disco local
            //Storage::disk('local')->put('n.xml',  File::get($xml));
            //Storage::disk('local')->put('n.pdf',  File::get($pdf));
                
             return Response(['msg'=>'success', 'data'=> $request->all(), 'code' => 200], 200)->header('Content-Type', 'application/json');
      
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function updateStatusPagos( Request $request )
    {
         try{   

            foreach ($request->input('data') as $key => $value) {
                # code...
                Llamados::where('id', $key)->update([               
                    'estatus_pago' => 'Tránsito a Pago'
                ]);
            }
                
             return Response(['msg'=>'success', 'data'=> $request->input('data'), 'code' => 200], 200)->header('Content-Type', 'application/json');
      
        } catch(\Exception $e){
             \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    public function getPagosCompletadoActores( Request $request )
    {
          try{
            if($request->isMethod('post') && $request->ajax()){

                $pagos = Llamados::allLlamadosPagoCompletado($request->input('actor_search'));
            }
            return Response(['msg' => 'success', 'pagos' => $pagos ], 200)->header('Content-Type', 'application/json');
          } catch(\Exception $e){
              \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
              \Log::error(' Trace2: ' .$e->getTraceAsString());
              return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
          }
    }

    public function showStatusActores()
    {
        try{

            return view('mgcontabilidad::pagos.show-status-actores');
          } catch(\Exception $e){
              \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
              \Log::error(' Trace2: ' .$e->getTraceAsString());
              return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
          }
    }

    public function getPagosStatusActores( Request $request )
    {
          try{
            if($request->isMethod('post') && $request->ajax()){

                $estatus = Llamados::allLlamadosStatusPago($request->input('status_search'));
                return Response(['msg' => 'success', 'code' => 200, 'estatus' => $estatus ], 200)->header('Content-Type', 'application/json');
            }
            
          } catch(\Exception $e){
              \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
              \Log::error(' Trace2: ' .$e->getTraceAsString());
              return Response(['error' => 'Error: Revisar con el administrador' ], 400)->header('Content-Type', 'application/json');
          }
    }
}
