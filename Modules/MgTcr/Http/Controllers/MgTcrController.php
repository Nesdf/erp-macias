<?php

namespace Modules\MgTcr\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgTcrController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $tcrs = \Modules\MgTcr\Entities\Tcr::All();
        return view('mgtcr::index', compact('tcrs'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgtcr::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if( $request->method('post') && $request->ajax() ){
            
            $rules = [
                'tcr' => 'required|min:2|max:50'                
            ];
            
            $messages = [
                'tcr.required' => trans('mgtcr::ui.display.error_required', ['attribute' => trans('mgtcr::ui.attribute.tcr')]),
                'tcr.min' => trans('mgtcr::ui.display.error_min2', ['attribute' => trans('mgtcr::ui.attribute.tcr')]),
                'tcr.max' => trans('mgtcr::ui.display.error_max50', ['attribute' => trans('mgtcr::ui.attribute.tcr')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\MgTcr\Entities\Tcr::create([  
                    'tcr' => ucwords( $request->input('tcr') )
                ]);
                $request->session()->flash('message', trans('mgtcr::ui.flash.flash_create_tcr'));
                return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
            }
        }
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgtcr::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgTcr\Entities\Tcr::find($id); 
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
                'tcr' => 'required|min:2|max:50'                
            ];
            
            $messages = [
                'tcr.required' => trans('mgtcr::ui.display.error_required', ['attribute' => trans('mgtcr::ui.attribute.tcr')]),
                'tcr.min' => trans('mgtcr::ui.display.error_min2', ['attribute' => trans('mgtcr::ui.attribute.tcr')]),
                'tcr.max' => trans('mgtcr::ui.display.error_max50', ['attribute' => trans('mgtcr::ui.attribute.tcr')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\Mgtcr\Entities\Tcr::where('id', $request->input('id'))
                ->update([                  
                    'tcr' => ucwords( $request->input('tcr') )
                ]);
                $request->session()->flash('message', trans('mgtcr::ui.flash.flash_create_tcr'));
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
        \Modules\MgTcr\Entities\Tcr::destroy($id);
        \Request::session()->flash('message', trans('mgtcr::ui.flash.flash_delete_tcr'));
        return redirect('mgtcr');
    }
}
