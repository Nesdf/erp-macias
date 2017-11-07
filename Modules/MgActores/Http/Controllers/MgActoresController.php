<?php

namespace Modules\MgActores\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgActoresController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $actores = \Modules\MgActores\Entities\Actores::get();
        return view('mgactores::index', compact('actores'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgactores::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {

        try{
            $rules = [
                'nombre_completo' => 'required',
                'nombre_artistico' => 'required'                
            ];
            
            $messages = [
                'nombre_artistico.required' => trans('mgactores::ui.display.error_required', ['attribute' => trans('mgactores::ui.attribute.nombre_artistico')]),
                'nombre_completo.required' => trans('mgactores::ui.display.error_required', ['attribute' => trans('mgactores::ui.attribute.nombre_completo')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {

                $save = \Modules\MgActores\Entities\Actores::create([                 
                        'nombre_completo' => ( $request->input('nombre_completo') ) ?  ucwords(strtolower($request->input('nombre_completo')))  : null,
                        'nombre_artistico' => ( $request->input('nombre_artistico') ) ?  ucwords(strtolower($request->input('nombre_artistico')))  : null
                    ]);

                if($save){

                    if($request->input('folio1')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio1'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio2')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio2'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio3')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio3'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio4')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio4'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio5')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio5'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio6')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio6'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio7')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio7'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio7')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio7'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio8')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio8'),
                            'actor_id' => $save->id
                        ]);
                    }
                    if($request->input('folio9')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio9'),
                            'actor_id' => $save->id
                        ]);
                    }
                    
                }
                $request->session()->flash('message', trans('mgactores::ui.flash.flash_create_actor'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        } catch(\Exeption $e){
            report($e);
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgactores::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $actor =  \Modules\MgActores\Entities\Actores::find($id); 
        $credenciales =  \Modules\MgActores\Entities\FolioActores::Folios($id);
        return Response(['msg' => 'success', 'actor' => $actor, 'credenciales' => $credenciales], 200)->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        try{
            $rules = [
                'nombre_completo' => 'required',
                'nombre_artistico' => 'required'                
            ];
            
            $messages = [
                'nombre_artistico.required' => trans('mgactores::ui.display.error_required', ['attribute' => trans('mgactores::ui.attribute.nombre_artistico')]),
                'nombre_completo.required' => trans('mgactores::ui.display.error_required', ['attribute' => trans('mgactores::ui.attribute.nombre_completo')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                $id = $request->input('id');
                $save = \Modules\MgActores\Entities\Actores::where('id', $id)
                    ->update([                 
                    'nombre_completo' => ( $request->input('nombre_completo') ) ?  ucwords(strtolower($request->input('nombre_completo')))  : null,
                    'nombre_artistico' => ( $request->input('nombre_artistico') ) ?  ucwords(strtolower($request->input('nombre_artistico')))  : null
                ]);

                    if($save){

                    if($request->input('folio1')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio1'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio2')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio2'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio3')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio3'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio4')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio4'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio5')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio5'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio6')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio6'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio7')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio7'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio7')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio7'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio8')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio8'),
                            'actor_id' => $id
                        ]);
                    }
                    if($request->input('folio9')){
                        \Modules\MgActores\Entities\FolioActores::create([                 
                            'folio' => $request->input('folio9'),
                            'actor_id' => $id
                        ]);
                    }
                    
                }

                $request->session()->flash('message', trans('mgactores::ui.flash.flash_update_actor'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        } catch(\Exeption $e){
            report($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        \Modules\MgActores\Entities\Actores::destroy($id);
        \Request::session()->flash('message', trans('mgactores::ui.flash.flash_delete_actor'));
        return redirect('mgactores');
    }

    public function destroyFolio($id)
    {
        $folio = \Modules\MgActores\Entities\FolioActores::find($id);
        if(count($folio) > 0){
            \Modules\MgActores\Entities\FolioActores::destroy($id);
        }
        return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
        
    }
}
