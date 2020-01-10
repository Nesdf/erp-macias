<?php

namespace Modules\MgCatalogoTipoTrabajo\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgCatalogoTipoTrabajo\Entities\TiposTrabajo;
use Modules\MgCatalogoTipoTrabajo\Http\Requests\CatalogoTipoTrabajoRequest;
use Validator;

class MgCatalogoTipoTrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tipoTrabajo = TiposTrabajo::all();
        return view('mgcatalogotipotrabajo::index', compact('tipoTrabajo'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        try{
            if($request->isMethod('post')){
                $validate = new CatalogoTipoTrabajoRequest();
                $validator = Validator::make($request->all(), $validate->rules(), $validate->messages());
                if($validator->fails()) {
                    $data["status"] = "error";
                    $data["errors"] = $validator->errors();
                    return  response()->json($data, 400);
                }

                $guardar = new TiposTrabajo();
                $guardar->nombre = $request->nombre;
                $guardar->descripcion = $request->descripcion;

                if($guardar->save()){
                    $data['msg'] = 'success';
                    return response()->json($data, 200);
                }
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            $data["status"] = "error";
            $data["message"] = 'Ocurrio un error';
            $data["message2"] = $e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine();
            return  response()->json($data, 400);
        }
        
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
        return view('mgcatalogotipotrabajo::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgcatalogotipotrabajo::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        try{
            if($request->isMethod('post')){
                $validate = new CatalogoTipoTrabajoRequest();
                $validator = Validator::make($request->all(), $validate->rules(), $validate->messages());
                if($validator->fails()) {
                    $data["status"] = "error";
                    $data["errors"] = $validator->errors();
                    return  response()->json($data, 400);
                }

                $guardar = [];
                $guardar['nombre'] = $request->nombre;
                $guardar['descripcion'] = $request->descripcion;

                if(TiposTrabajo::where('id', $request->id)->update($guardar)){
                    $data['msg'] = 'success';
                    return response()->json($data, 200);
                }
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            $data["status"] = "error";
            $data["message"] = 'Ocurrio un error';
            $data["message2"] = $e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine();
            return  response()->json($data, 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
