<?php

namespace Modules\MgSucursales\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgSucursalesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $sucursales = \Modules\MgSucursales\Entities\Paises::Sucursales();
        $paises = \Modules\MgSucursales\Entities\Paises::All();
        return view('mgsucursales::index', compact('sucursales', 'paises'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgsucursales::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if($request->method('post')){
            \Modules\MgSucursales\Entities\Paises::create([
                'pais' => $request->input('pais')
            ]);
            $sucursales = \Modules\MgSucursales\Entities\Paises::Sucursales();
            return $this->index();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function storeCiudad(Request $request)
    {
        if($request->method('post')){
            \Modules\MgSucursales\Entities\Estados::create([
                'paisesId' => $request->input('paisId'),
                'estado' => $request->input('estado')
            ]);
            $sucursales = \Modules\MgSucursales\Entities\Paises::Sucursales();
            return $this->index();
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgsucursales::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgsucursales::edit');
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
    public function destroyCiudad($id)
    {
        \Modules\MgSucursales\Entities\Estados::destroy($id);
        return redirect('mgsucursales');
    }
}
