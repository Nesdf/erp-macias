<?php

namespace Modules\MgDestino\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgDestino\Entities\Destino;

class MgDestinoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $destinos = Destino::all();
        return view('mgdestino::index', compact('destinos'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgdestino::create');
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
                
                $valor = Destino::find($request->id)->destino;
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
        return view('mgdestino::edit');
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
    public function nuevoDestino(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){     
                
                // $validate = new GuardarRequest();
                // $this->validator=Validator::make($request->all(),$validate->rules(),$validate->messages());
                // if(!$this->validator->fails()){
                //     return Diagnostico::guardar($request);
                // }
                
                Destino::create([                 
                    'destino' => ucwords( $request->input('destino') )
                ]);
                $request->session()->flash('message', 'Destino '. $request->input('destino') .' creado con éxito');
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

    public function updateDestino(Request $request)
    {
        try{
            if( $request->method('post') && $request->ajax() ){         
                
                Destino::where( 'id', $request->input('id') )
                        ->update([					
                            'destino' => ucwords( $request->input('destino') )
                        ]);
                        $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_destino'));
                        return Response()->json(['msg' => 'success'], 200);	
            }
        } catch(\Exception $e){
                return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }
}
