<?php

namespace Modules\MgMetodoEnvio\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgMetodoEnvio\Entities\MetodoEnvio;

class MgMetodoEnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $metodoEnvio = MetodoEnvio::all();
        return view('mgmetodoenvio::index', compact('metodoEnvio'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgmetodoenvio::create');
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
                
                // $validate = new GuardarRequest();
                // $this->validator=Validator::make($request->all(),$validate->rules(),$validate->messages());
                // if(!$this->validator->fails()){
                //     return Diagnostico::guardar($request);
                // }
                
                $data = MetodoEnvio::find($request->id)->metodo_envio;
                $request->session()->flash('message', 'Metodo envio '. $request->input('metodo_envio') .' creado con éxito');
                return Response()->json(['msg' => 'success', 'valor' => $data], 200);
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
        return view('mgmetodoenvio::edit');
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
    public function createMetodoEnvio(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){     
                
                // $validate = new GuardarRequest();
                // $this->validator=Validator::make($request->all(),$validate->rules(),$validate->messages());
                // if(!$this->validator->fails()){
                //     return Diagnostico::guardar($request);
                // }
                
                MetodoEnvio::create([                 
                    'metodo_envio' => ucwords( $request->metodo_envio )
                ]);
                $request->session()->flash('message', 'Metodo envio '. $request->input('metodo_envio') .' creado con éxito');
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

    public function updateMetodoEnvio(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){         
                
                MetodoEnvio::where( 'id', $request->id )
                        ->update([					
                            'metodo_envio' => ucwords( $request->metodo_envio )
                        ]);
                        $request->session()->flash('message', 'Método envio exitoso');
                        return Response()->json(['msg' => 'success'], 200);	
            }
        } catch(\Exception $e){
                return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }
}
