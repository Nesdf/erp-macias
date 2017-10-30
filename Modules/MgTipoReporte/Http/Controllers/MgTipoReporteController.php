<?php

namespace Modules\MgTipoReporte\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgTipoReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $reportes = \Modules\MgTipoReporte\Entities\TipoReporte::get();
        return view('mgtiporeporte::index', compact('reportes'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgtiporeporte::create');
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
                'reporte' => 'required|min:2|max:50'                
            ];
            
            $messages = [
                'reporte.required' => trans('mgtiporeporte::ui.display.error_required', ['attribute' => trans('mgtiporeporte::ui.attribute.reporte')]),
                'reporte.min' => trans('mgtiporeporte::ui.display.error_min2', ['attribute' => trans('mgtiporeporte::ui.attribute.reporte')]),
                'reporte.max' => trans('mgtiporeporte::ui.display.error_max50', ['attribute' => trans('mgtiporeporte::ui.attribute.reporte')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\MgTipoReporte\Entities\TipoReporte::create([  
                    'tipo' => ucwords( $request->input('reporte') )
                ]);
                $request->session()->flash('message', trans('mgtiporeporte::ui.flash.flash_create_reporte'));
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
        return view('mgtiporeporte::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return \Modules\MgTipoReporte\Entities\TipoReporte::find($id); 
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
                'reporte' => 'required|min:2|max:50'                
            ];
            
            $messages = [
                'reporte.required' => trans('mgtiporeporte::ui.display.error_required', ['attribute' => trans('mgtiporeporte::ui.attribute.reporte')]),
                'reporte.min' => trans('mgtiporeporte::ui.display.error_min2', ['attribute' => trans('mgtiporeporte::ui.attribute.reporte')]),
                'reporte.max' => trans('mgtiporeporte::ui.display.error_max50', ['attribute' => trans('mgtiporeporte::ui.attribute.reporte')])
            ]; 
            
            $validator = \Validator::make($request->all(), $rules, $messages);          
            
            if ( $validator->fails() ) {
                return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
            } else {
                \Modules\MgTipoReporte\Entities\TipoReporte::where('id', $request->input('id'))
                ->update([  
                    'tipo' => ucwords( $request->input('reporte') )
                ]);
                $request->session()->flash('message', trans('mgtiporeporte::ui.flash.flash_create_reporte'));
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
        \Modules\MgTipoReporte\Entities\TipoReporte::destroy($id);
        \Request::session()->flash('message', trans('mgtiporeporte::ui.flash.flash_delete_reporte'));
        return redirect('mgtiporeporte');
    }
}
