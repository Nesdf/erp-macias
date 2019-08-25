<?php

namespace Modules\MgEntregables\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgEntregables\Entities\Entregables;

class MgEntregablesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $entregables = Entregables::all();
        return view('mgentregables::index', compact('entregables'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgentregables::create');
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
    public function show(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){         
                
                $valor = Entregables::find($request->id)->entregable;
                $request->session()->flash('message', 'Entregable');
                return Response()->json(['msg' => 'success', 'valor' => $valor], 200);	
            }
        } catch(\Exception $e){
                return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgentregables::edit');
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
     * Permite crear un catálogo de destino
     * @return Response
     */
    public function nuevoEntregable(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){     
                
                // $validate = new GuardarRequest();
                // $this->validator=Validator::make($request->all(),$validate->rules(),$validate->messages());
                // if(!$this->validator->fails()){
                //     return Diagnostico::guardar($request);
                // }
                
                Entregables::create([                 
                    'entregable' => ucwords( $request->entregable )
                ]);
                $request->session()->flash('message', 'Entregable '. $request->entregable.' creado con éxito');
                return Response()->json(['msg' => 'success'], 200);
            }
        } catch(\Exception $e){
                return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }


    /**
     * Permite crear un catálogo de destino
     * @return Response
     */

    public function updateEntregable(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){         
                
                Entregables::where( 'id', $request->id )
                        ->update([					
                            'entregable' => ucwords( $request->entregable )
                        ]);
                        $request->session()->flash('message', 'Entregable');
                        return Response()->json(['msg' => 'success'], 200);	
            }
        } catch(\Exception $e){
                return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }
}
