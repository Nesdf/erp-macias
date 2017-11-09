<?php

namespace Modules\MgTimecode\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgTimecodeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $timecodes = \Modules\MgTimecode\Entities\Timecodes::get();
        return view('mgtimecode::index', compact('timecodes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgtimecode::create');
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
                    'timecode' => 'required|min:2|max:50'                
                ];
                
                $messages = [
                    'timecode.required' => trans('mgtimecode::ui.display.error_required', ['attribute' => trans('mgtimecode::ui.attribute.timecode')]),
                    'timecode.min' => trans('mgtimecode::ui.display.error_min2', ['attribute' => trans('mgtimecode::ui.attribute.timecode')]),
                    'timecode.max' => trans('mgtimecode::ui.display.error_max50', ['attribute' => trans('mgtimecode::ui.attribute.timecode')])
                ]; 
                
                $validator = \Validator::make($request->all(), $rules, $messages);          
                
                if ( $validator->fails() ) {
                    return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
                } else {
                    \Modules\MgTimecode\Entities\Timecodes::create([                 
                        'timecode' => ucwords( $request->input('timecode') )
                    ]);

                    return Response(['msg' => "success", 200])->header('Content-Type', 'application/json');
                }
            } 
        } catch(\Exception $e){
             return Response(['msgError' => "Ocurrio un error, verificar con el administrador.", 'error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgtimecode::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgTimecode\Entities\Timecodes::find($id);  
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
                'timecode' => 'required|min:2|max:50'                
            ];
            
            $messages = [
                'timecode.required' => trans('mgtimecode::ui.display.error_required', ['attribute' => trans('mgtimecode::ui.attribute.timecode')]),
                'timecode.min' => trans('mgtimecode::ui.display.error_min2', ['attribute' => trans('mgtimecode::ui.attribute.timecode')]),
                'timecode.max' => trans('mgtimecode::ui.display.error_max50', ['attribute' => trans('mgpersonal::ui.attribute.timecode')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\MgTimecode\Entities\Timecodes::where('id', $request->input('id'))
                    ->update([                 
                    'timecode' => ucwords( $request->input('timecode') )
                ]);
                $request->session()->flash('message', trans('mgtimecode::ui.flash.flash_create_timecode'));
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
        \Modules\MgTimecode\Entities\Timecodes::destroy($id);
        \Request::session()->flash('message', trans('mg::ui.flash.flash_delete_timecode'));
        return redirect('mgtimecode');
    }
}
