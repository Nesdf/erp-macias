<?php

namespace Modules\MgTraductores\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgTraductoresController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index($id)
    {
        $proyecto = \Modules\MgEpisodios\Entities\Proyectos::find($id);
        $vias = \Modules\MgEpisodios\Entities\Vias::get();
        $proyecto_id = $id;
        $episodios = \Modules\MgEpisodios\Entities\Episodios::allEpisodioOfProject($id);
        $tcrs = \Modules\MgEpisodios\Entities\Tcr::All();
        $salas = \Modules\MgEpisodios\Entities\Salas::All();
        $productores = \Modules\MgEpisodios\Entities\Users::Productores();
        $responsables = \Modules\MgEpisodios\Entities\Users::Responsables();
        $traductores = \Modules\MgEpisodios\Entities\Users::traductores();
        return view('mgtraductores::traductores', compact('proyecto', 'vias', 'proyecto_id', 'episodios', 'tcrs', 'salas', 'productores', 'responsables', 'traductores'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgtraductores::create');
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
        return view('mgtraductores::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgtraductores::edit');
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
}
