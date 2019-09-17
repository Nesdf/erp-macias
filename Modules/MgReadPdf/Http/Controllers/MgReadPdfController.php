<?php

namespace Modules\MgReadPdf\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Spatie\PdfToText\Pdf; 
use \Modules\MgCalendar\Entities\Proyectos;
use \Modules\MgCalendar\Entities\Episodios;
use \Modules\MgReadPdf\Entities\ActorPersonaje;

class MgReadPdfController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $proyectos = Proyectos::get();
        $episodios = [];

        return view('mgreadpdf::index', compact('proyectos', 'episodios'));

    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function pdfActores(Request $request)
    {
        try{
            $episodio = $request->input('allproyectos');
            $folio = $request->input('episodios');
            $data1 = $request->input('datos');
            //$data1 = strip_tags($data1);
            //$data = htmlspecialchars($data1);
            $data = explode('</p><p>', $data1);
            //$datos  = intval(preg_replace('/[^0-9]+/', '', $data[0]), 10);            //$arrayHtml = array('&nbs;', '<>', '</>', 'p', 'nbs', '<p>', '</p>');
            for( $i=0; $i < count($data); $i++ ) {
                //$loops = intval(preg_replace('/[^0-9]+/', '', $data[$i]), 10);
                //$personaje = preg_replace('/[^a-zA-Z]+/', '', str_replace($arrayHtml, "", $data[$i]));

                $actor = explode('-', $data[$i]);

                $existe = ActorPersonaje::where(['episodio_folio' => $folio, 'personaje' => $actor[0], 'loops' => $actor[1]])->get();

                if(count($existe) == 0){
                    ActorPersonaje::create([
                        'episodio_folio' => $folio,
                        'personaje' => str_replace('<p>', "", $actor[0]) ,
                        'loops' => $actor[1],
                        'fijo' => false,
                        'asignado' => false,
                        'proyecto' => $episodio

                    ]);
                }

                //$resultado = str_replace($valor, "", $data[$i]);
            }
            $proyectos = Proyectos::get();
            $episodios = [];
            return redirect('mgreadpdf')->with('status', 'Se alamcenaron los personajes exitosamente.');
        } catch(\Exception $e){
            \Log::info($e->getMessage() . ' Archivo: ' . $e->getFile() . ' Codigo '. $e->getCode() . ' Linea: ' . $e->getLine());
            \Log::error(' Trace2: ' .$e->getTraceAsString());
           return $request->session()->flash('success', trans('Error al cargar los datos, favor de revisar con el administrador'));
        }

        //print_r($data);
        //print_r($numero);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $proyectos = Proyectos::get();
        $episodios = [];
        $personajes = [];

        return view('mgreadpdf::modificar', compact('proyectos', 'episodios', 'personajes'));
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
        return view('mgreadpdf::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('mgreadpdf::edit');
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
    public function destroy()
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function getEpisodiosPersonajes( $id )
    {
        return Episodios::where('proyectoId', '=', $id)->get();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function listaPersonajes( $folio )
    {
        return ActorPersonaje::getPersonajesByEpisodio($folio);
    }

    public function updatePersonaje( Request $request )
    {
        try{
            if($request->isMethod('post')){
                $personaje = ActorPersonaje::find($request->id);
                $personaje->personaje = $request->personaje;
                $personaje->save();
                $request->session()->flash('status', 'Se '.$request->personje.' actualizó correctamente.');
                return Response()->json(['msg' => 'success'], 200);
            }
        } catch(\Exception $e){
    		return Response(['error' => $e->getMessage()], 404)->header('Content-Type', 'application/json');
    	}
        
    }
}
