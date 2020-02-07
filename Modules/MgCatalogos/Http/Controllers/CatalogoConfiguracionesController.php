<?php

namespace Modules\MgCatalogos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgCatalogos\Entities\CatalogoConfiguraciones;
use Modules\MgCatalogos\Http\Requests\ConfiguracionRequest;
use Validator;

class CatalogoConfiguracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $configuraciones = CatalogoConfiguraciones::all();
        return view('mgcatalogos::catalogo-configuracion', compact('configuraciones'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        try{
            if($request->isMethod('post')){
                $validate = new ConfiguracionRequest();
                $validator = Validator::make($request->all(), $validate->rules(), $validate->messages());
                if($validator->fails()) {
                    $data["status"] = "error";
                    $data["errors"] = $validator->errors();
                    return  response()->json($data, 400);
                }

                $guardar = new CatalogoConfiguraciones();
                $new_nombre = str_replace(" ", "", $request->nombre);
                $guardar->nombre = strtolower($new_nombre);

                if($guardar->save()){
                    $data['msg'] = 'success';
                    return response()->json($data, 200);
                }
            }
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            $data["status"] = "error";
            $data["message"] = 'Ocurrio un error';
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
        return view('mgcatalogos::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgcatalogos::edit');
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
                $validate = new ConfiguracionRequest();
                $validator = Validator::make($request->all(), $validate->rules(), $validate->messages());
                if($validator->fails()) {
                    $data["status"] = "error";
                    $data["errors"] = $validator->errors();
                    return  response()->json($data, 400);
                }

                $guardar = CatalogoConfiguraciones::find($request->id);
                $new_nombre = str_replace(" ", "", $request->nombre);
                $guardar->nombre = strtolower($new_nombre);

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
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }
}
