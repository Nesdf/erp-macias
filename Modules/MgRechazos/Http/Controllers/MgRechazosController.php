<?php

namespace Modules\MgRechazos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgClientes\Entities\Clientes;
use Modules\MgRechazos\Entities\Rechazos;
use Modules\MgCatalogos\Entities\TipoError;
use Modules\MgCatalogos\Entities\DepartamentoResponsable;
use Modules\MgProyectos\Entities\Proyectos;
use Modules\MgPersonal\Entities\User;
use Modules\MgEpisodios\Entities\Episodios;
use Modules\MgPuestos\Entities\Puestos;

class MgRechazosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $clientes = Clientes::all();
        $idiomas = Rechazos::IDIOMAS;
        $nivelGravedad = Rechazos::NIVELGRAVEDAD;
        $numeroRechazo = Rechazos::NUMERORECHAZO;
        $tipoErrores = TipoError::all();
        $deptoResponsable = DepartamentoResponsable::all();
        $coordinadores = User::Where('job', 11)->get();
        $directores = User::Where('job', 1)->get();
        $productores = User::Where('job', 2)->get();
        $editores = User::WhereIn('job', [9,14,16])->get();
        $regrabadores = User::Where('job', 7)->get();
        $puestoResponsable = Puestos::all();
        $rechazos = Rechazos::listaRechazos();
        return view('mgrechazos::index', compact('clientes', 'idiomas', 'tipoErrores', 'deptoResponsable', 'nivelGravedad', 'numeroRechazo', 'coordinadores', 'productores', 'directores', 'editores', 'regrabadores', 'puestoResponsable','rechazos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        if($request->isMethod('post')){
            if(Rechazos::guardarRechazos($request)){
                $data['message'] = "Se creó correctamente el rechazo";
                $data['status'] = 'success';
                return response()->json($data, 200);
            } else {
                $data['message'] = "Error al generar el  rechazo";
                $data['status'] = 'errors';
                return response()->json($data, 400);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if($request->isMethod('post')){
            return (Rechazos::guardarRechazos($request)) ? true : false;
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgrechazos::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgrechazos::edit');
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
     * Remove the specified resource from storage.
     * @return Response
     */
    public function modalRechazos()
    {
        try{
            $clientes = [];
            return view('', compact('listTipoError', 'listDepartamentoResponsable', 'clientes'));

        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            $data["status"] = "error";
            $data["message"] = 'Ocurrio un error';
            return  response()->json($data, 400);
        }
    }

    public function rechazosSelectProyectos(Request $request){
        if($request->isMethod('post')){
            $data = Proyectos::where('clienteId',$request->id)->get();
            return response()->json($data, 200);
        }
    }

    public function rechazosSelectTemporada(Request $request) {
        if($request->isMethod('post')){
            $data = Episodios::where('proyectoId', $request->id)->get();
            return response()->json($data, 200);
        }
    }

    public function rechazosSelectProyectosId(Request $request){
        if($request->isMethod('post')){
            $data = Proyectos::where('id',$request->id)->get();
            return response()->json($data, 200);
        }
    }

    public function rechazosSelectEpisodios(Request $request) {
        if($request->isMethod('post')){
            $data = Episodios::where('proyectoId', $request->id)->get();
            return response()->json($data, 200);
        }
    }

    public function listaRechazos(Request $request){
        if($request->isMethod('post')){
            $data = Rechazos::listaPersonalizadaRechazos($request);
            return response()->json(['data'=>$data], 200);
        }
    }
}
