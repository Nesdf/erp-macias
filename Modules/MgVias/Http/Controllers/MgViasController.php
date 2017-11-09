<?php

namespace Modules\MgVias\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgViasController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $vias = \Modules\MgVias\Entities\Vias::get();
        return view('mgvias::index', compact('vias'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgvias::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
		try{
            if( $request->method('post') && $request->ajax() ){
            
                $rules = [
                    'via' => 'required|min:2|max:50'                
                ];
                
                $messages = [
                    'via.required' => trans('mgvias::ui.display.error_required', ['attribute' => trans('mgvias::ui.attribute.via')]),
                    'via.min' => trans('mgvias::ui.display.error_min2', ['attribute' => trans('mgvias::ui.attribute.via')]),
                    'via.max' => trans('mgvias::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.via')])
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    \Modules\MgVias\Entities\Vias::create([                 
                        'via' => ucwords( $request->input('via') )
                    ]);
                    $request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_peronal'));
                    return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
                }
            } catch(\Exception $e){
                return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
            }
        }	
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgvias::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgVias\Entities\Vias::find($id);   
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
		if( $request->method('post') && $request->ajax() ){
			
			$rules = [
				'via' => 'required|min:2|max:50'				
			];
			
			$messages = [
				'via.required' => trans('mgvias::ui.display.error_required', ['attribute' => trans('mgvias::ui.attribute.via')]),
				'via.min' => trans('mgvias::ui.display.error_min2', ['attribute' => trans('mgvias::ui.attribute.via')]),
				'via.max' => trans('mgvias::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.via')])
			]; 
			
			$validator = \Validator::make($request->all(), $rules, $messages);			
			
			if ( $validator->fails() ) {
				return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
			} else {
				\Modules\MgVias\Entities\Vias::where( 'id', $request->input('id') )
				->update([					
					'via' => ucwords( $request->input('via') )
				]);
				$request->session()->flash('message', trans('mgpersonal::ui.flash.flash_create_peronal'));
				return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
			}
		}	
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
		\Modules\MgVias\Entities\Vias::destroy($id);
		//\Request::session()->flash('message', trans('mgvias::ui.flash.flash_delete_via'));
		return redirect('mgvias');
    }
}
