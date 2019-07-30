<?php

namespace Modules\MgCatalogos\Http\Controllers;

use App\Interfaces\BaseInterfaces;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Modules\MgCatalogos\Entities\TipoError;
use Modules\MgCatalogos\Http\Requests\DepartamentoResponsableRequest;
use Validator;

class TipoErrorController extends Controller implements BaseInterfaces
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tipoError = TipoError::all();
        return view('mgcatalogos::tipo-error', compact('tipoError'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        try{
            if($request->isMethod('post')){
                $validate = new DepartamentoResponsableRequest();
                $validator = Validator::make($request->all(), $validate->rules(), $validate->messages());
                if($validator->fails()) {
                    $data["status"] = "error";
                    $data["errors"] = $validator->errors();
                    return  response()->json($data, 400);
                }

                $guardar = new TipoError();
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
                $validate = new DepartamentoResponsableRequest();
                $validator = Validator::make($request->all(), $validate->rules(), $validate->messages());
                if($validator->fails()) {
                    $data["status"] = "error";
                    $data["errors"] = $validator->errors();
                    return  response()->json($data, 400);
                }

                $guardar = TipoError::find($request->id);
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
