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
        $paises = \Modules\MgSucursales\Entities\Paises::All();
        #$sucursales = \Modules\MgSucursales\Entities\Paises::Sucursales();
        
        
        
        return view('mgsucursales::index', compact('paises'));
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
        try{

            if( $request->method('post') ){

                $validador = \Validator::make($request->all(), [
                    'pais' => 'required|unique:paises',
                ])->validate();

                $surname = str_replace(' ', '_', strtolower($request->input('pais')));

                \Modules\MgSucursales\Entities\Paises::create([
                    'pais' => ucfirst(strtolower($request->input('pais'))),
                    'surname' => $surname
                ]);
                \Request::session()->flash('success', 'Se agregó exitosamente.');
                $sucursales = \Modules\MgSucursales\Entities\Paises::Sucursales();
                return Redirect()->route('mgsucursales');
            }
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function storeCiudad(Request $request)
    {
        try{

            if( $request->method('post') && $request->ajax() ){

                $rules = [
                    'estado' => 'required|unique:estados',              
                ];
                
                $messages = [
                    'estado.unique' => 'Estado ya existe'
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages); 

                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                }

                \Modules\MgSucursales\Entities\Estados::create([
                    'paisesId' => $request->input('paisId'),
                    'estado' => $request->input('estado')
                ]);

                \Request::session()->flash('success', 'Se agregó exitosamente.');
                return Response(['msg' => 'success', 200])->header('Content-Type', 'application/json');
                //return Redirect()->route('mgsucursales');
            }
        } catch(\Exception $e){
            return $e->getMessage();
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
    public function edit(Request $request)
    {
        if($request->isMethod("POST") && $request->ajax()){
            
            try{

                \Validator::make($request->all(), [
                    'pais' => 'required|unique:paises',
                ])->validate();

                $surname = str_replace(' ', '_', strtolower($request->input('pais')));

                \Modules\MgSucursales\Entities\Paises::where('id', $request->input('id'))
                ->update([
                    'pais' => ucfirst(strtolower($request->input('pais'))),
                    'surname' => $surname
                ]);
                \Request::session()->flash('success', 'Se agregó exitosamente.');
                $sucursales = \Modules\MgSucursales\Entities\Paises::Sucursales();
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');

            } catch(\Exception $e){
                return $e->getMessage();
            }
            
        }
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
    public function destroy($id)
    {
        try{

            if(\Modules\MgSucursales\Entities\Paises::destroy($id)){
                \Modules\MgSucursales\Entities\Estados::destroyAll($id);
            }
            \Request::session()->flash('success', trans('Se eliminó satisfactoriamente.'));
            return redirect('mgsucursales');
        } catch(\Exception $e){
            \Request::session()->flash('error', trans('Intentarlo más tarde.'));
            // $e->getMessage();
            return redirect('mgsucursales');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroyCiudad($id)
    {
        \Modules\MgSucursales\Entities\Estados::destroy($id);
        \Request::session()->flash('success', trans('Se eliminó satisfactoriamente.'));
        return redirect('mgsucursales');
    }

    public function editEstado(Request $request)
    {
        try{
            if($request->isMethod('post') && $request->ajax()){
                 $rules = [
                    'estado' => 'required|unique:estados'            
                ];
                
                $messages = [
                    'estado.unique' => 'Estado ya existe',
                    'estado.required' => 'Se requiere el Estado'
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages); 

                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                }

                \Modules\MgSucursales\Entities\Estados::where('id', $request->input('id'))
                ->update([
                    'estado' => $request->input('estado')
                ]);
                \Request::session()->flash('success', trans('Se agregó con éxito.'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        } catch(\Exception $e){
            return $e->getMessage();
        }
    }
}
