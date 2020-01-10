<?php

namespace Modules\MgTrafico\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgProgramacionAvances\Entities\Proyectos;

class MgTraficoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $proyectos = Proyectos::getAllProjects();

        return view('mgtrafico::index', compact('proyectos'));
        //return view('mgtrafico::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgtrafico::create');
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
        return view('mgtrafico::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgtrafico::edit');
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
    public function fechaEmbarqueUpdate(Request $request)
    {
        try{

			$proyectos = Proyectos::fullProyects();
	        $clientes = Clientes::get();
	        $idiomas = Idiomas::get();
	        $vias = Vias::get();
            
            $request->session()->flash('success', trans('mgproyectos::ui.flash.flash_create_cliente'));
					return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
		} catch(\Exception $e){

            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }
    
}
