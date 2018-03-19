<?php

namespace Modules\MgProyectos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class MgProyectosController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
		try{

			$proyectos = \Modules\MgProyectos\Entities\Proyectos::fullProyects();
	        $clientes = \Modules\MgProyectos\Entities\Clientes::get();
	        $idiomas = \Modules\MgProyectos\Entities\Idiomas::get();
	        $vias = \Modules\MgEpisodios\Entities\Vias::get();
	        return view('mgproyectos::proyectos', compact('idiomas', 'clientes', 'proyectos', 'vias'));
		} catch(\Exception $e){

            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('mgproyectos::create');
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
				//dd($request->all());
				$rules = [
					'cliente' => 'required'				
				];
				
				$messages = [
					'cliente.required' => trans('mgproyectos::ui.display.error_required', ['attribute' => trans('mgproyectos::ui.attribute.cliente')])
				]; 
				
				$validator = \Validator::make($request->all(), $rules, $messages);			
				
				if ( $validator->fails() ) {
					return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
				} else {
					
					\Modules\MgProyectos\Entities\Proyectos::create([					
						'clienteId' => $request->input('cliente'),
						'titulo_original' => ucwords( strtolower($request->input('titulo_serie')) ),
						'titulo_aprobado' => ucwords( strtolower($request->input('titulo_proyecto')) ),
						'statusId' => true,
						'm_and_e' => true,
						'titulo_espanol' => ($request->has('titulo_espanol')) ? ucwords( strtolower($request->input('titulo_espanol')) ) : null,
						'titulo_ingles' => ($request->has('titulo_ingles')) ? ucwords( strtolower($request->input('titulo_ingles')) ) : null,
						'titulo_portugues' => ($request->has('titulo_portugues')) ? ucwords( strtolower($request->input('titulo_portugues')) ) : null,
						'viaId' => $request->input('via') ,
						'temporada' => $request->input('temporada'),
						'adr_ingles' => ( $request->input('adr_ingles') == 'on' ) ? true : false,
						'adr_portugues' => ( $request->input('adr_portugues') == 'on') ? true : false,
						'adr_espanol' => ( $request->input('adr_espanol') == 'on' ) ? true : false,
						'mix20' => ( $request->input('mix20') == 'on' ) ? true : false,
						'mix51' => ( $request->input('mix51') == 'on' ) ? true : false,
						'mix71' => ( $request->input('mix71') == 'on' ) ? true : false,
						'relleno_mande' => ( $request->input('relleno_mande') ) ? true : false,
						'm_e_20' => ( $request->input('m_e_20') == 'on' ) ? true : false,
						'm_e_51' => ( $request->input('m_e_51') == 'on' ) ? true : false,
						'm_e_71' => ( $request->input('m_e_71') == 'on' ) ? true : false,
						'subt_espanol' => ( $request->input('subtitulaje_espanol') ) ? true : false,
						'subt_ingles' => ( $request->input('subtitulaje_ingles') ) ? true : false,
						'subt_portugues' => ( $request->input('subtitulaje_portugues') ) ? true : false
					]);
					
					
					$request->session()->flash('success', trans('mgproyectos::ui.flash.flash_create_cliente'));
					return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
				}
			}
		} catch(\Exception $e){
			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
			return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
		}
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('mgproyectos::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        try{
        	return \Modules\MgProyectos\Entities\Proyectos::find($id); 
        } catch(\Exception $e){
			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
		try{

			if( $request->isMethod('post') && $request->ajax() ){
		
				$rules = [
					'cliente' => 'required'
				];
				
				$messages = [
					'cliente.required' => trans('mgproyectos::ui.display.error_required', ['attribute' => trans('mgproyectos::ui.attribute.cliente')])
				]; 
				
				$validator = \Validator::make($request->all(), $rules, $messages);			
				
				if ( $validator->fails() ) {
					return Response(['msg' => $validator->errors()->all()], 402)->header('Content-Type', 'application/json');
				} else {
					\Modules\MgProyectos\Entities\Proyectos::where('id', $request->input('id'))
						->update([					
							'clienteId' => $request->input('cliente'),
							'titulo_original' => ucwords( $request->input('titulo_serie') ),
							'titulo_aprobado' => ucwords( $request->input('titulo_proyecto') ),
							'statusId' => true,
							'm_and_e' => true,
							'titulo_espanol' => ( $request->has('titulo_espanol') ) ? ucwords( $request->input('titulo_espanol') ) : null,
							'titulo_ingles' => ($request->has('titulo_ingles')) ? ucwords( $request->input('titulo_ingles') ) : null,
							'titulo_portugues' => ($request->has('titulo_portugues')) ? ucwords( $request->input('titulo_portugues') ) : null,
							'viaId' => $request->input('via') ,
							'temporada' => $request->input('temporada'),
							'temporada' => $request->input('temporada'),
							'adr_ingles' => ( $request->input('adr_ingles') ) ? true : false,
							'adr_portugues' => ( $request->input('adr_portugues') ) ? true : false,
							'adr_espanol' => ( $request->input('adr_espanol') ) ? true : false,
							'mix20' => ( $request->input('mix20') ) ? true : false,
							'mix51' => ( $request->input('mix51') ) ? true : false,
							'mix71' => ( $request->input('mix71') ) ? true : false,
							'relleno_mande' => ( $request->input('relleno_mande') ) ? true : false,
							'm_e_20' => ( $request->input('m_e_20') ) ? true : false,
							'm_e_51' => ( $request->input('m_e_51') ) ? true : false,
							'm_e_71' => ( $request->input('m_e_71') ) ? true : false,
							'subt_espanol' => ( $request->input('subtitulaje_espanol') ) ? true : false,
							'subt_ingles' => ( $request->input('subtitulaje_ingles') ) ? true : false,
							'subt_portugues' => ( $request->input('subtitulaje_portugues') ) ? true : false
						]);
					
					$request->session()->flash('success', trans('mgproyectos::ui.flash.flash_create_cliente'));
					return Response(['msg' => 'success'], 200)->header('Content-Type', 'application/json');
				}
			} 
		} catch(\Exception $e) {
			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
			return Response(['error' => $e->getMessage()], 400)->header('Content-Type', 'application/json');
		}
		
    }
    

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
		try{

			\Modules\MgProyectos\Entities\Proyectos::destroy($id);
			\Request::session()->flash('success', trans('mgproyectos::ui.flash.flash_delete_proyecto'));
			return redirect('mgproyectos');
		} catch(\Exception $e) {
			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
	}
	
	public function proyecto($id)
	{
		try{

			$proyecto = \Modules\MgProyectos\Entities\Proyectos::proyecto($id);
			return Response(['msg' => 'success', 'proyecto' => $proyecto], 200)->header('Content-Type', 'application/json');
		} catch(\Exception $e) {
			\Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
		}
	}
}
