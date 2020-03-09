<?php

namespace Modules\MgRechazos\Entities;

use Illuminate\Database\Eloquent\Model;

class Rechazos extends Model
{
    //
    protected $table = 'rechazos';
    protected $fillable = [
        'fecha_rechazo',
        'fecha_envio_cliente',
        'cliente',
        'titulo_programa',
        'temporada',
        'id_numero_episodio',
        'idioma',
        'id_tipo_error',
        'id_departamento_responsable',
        'descripcion_motivo_rechazo',
        'nivel_gravedad',
        'número_rechazo',
        'id_coordinador',
        'id_productor',
        'id_director',
        'id_editor',
        'id_grabador',
        'observaciones',
        'tomar_acciones_prevencion',
        'accion_tomada',
        'created_at',
        'updated_at'
    ];
    
    CONST IDIOMAS = [
        'LAS',
        'BPO'
    ];

    CONST NIVELGRAVEDAD = [
        '1. Muy grave',
        '2. Grave',
        '3. Informativo'
    ];

    CONST NUMERORECHAZO = [
        '1',
        '2',
        '3'
    ];

    public static function listaRechazos(){
        return Rechazos::select([
            'fecha_rechazo',
            'fecha_original_envio',
            'clientes.razon_social AS cliente',
            'proyectos.titulo_original AS titulo_programa',
            'proyectoTemporada.temporada AS temporada',
            'idioma',
            'rechazo_tipo_error.nombre AS tipo_error',
            'rechazo_departamento_responsable.nombre AS departamento_responsable',
            'jobs.job AS puesto_responsable',
            'nombre_completo_responsable',
            'nivel_gravedad',
            'numero_rechazo',
            'descripcion_motivo_rechazo',
            \DB::raw("CONCAT(coordinador.name,' ', coordinador.ap_paterno) AS nombre_coordinador"),
            \DB::raw("CONCAT(productor.name,' ', productor.ap_paterno) AS nombre_productor"),
            \DB::raw("CONCAT(director.name,' ', director.ap_paterno) AS nombre_director"),
            \DB::raw("CONCAT(editor.name,' ', editor.ap_paterno) AS nombre_editor"),
            \DB::raw("CONCAT(regrabador.name,' ', regrabador.ap_paterno) AS nombre_regrabador"),
            'rechazos.observaciones',
            'tomar_acciones_prevencion',
            'acciones_tomadas',
            'numEpisodios.num_episodio AS num_episodio'
            ])
        ->join('clientes', 'clientes.id', '=', 'rechazos.cliente')
        ->join('proyectos', 'proyectos.id', '=', 'rechazos.titulo_programa')
        ->join('proyectos AS proyectoTemporada', 'proyectoTemporada.id', '=', 'rechazos.id_episodio_temporada')
        ->join('episodios AS numEpisodio', 'numEpisodio.id', '=', 'rechazos.id_episodio_temporada')
        ->join('rechazo_tipo_error', 'rechazo_tipo_error.id', '=', 'rechazos.id_tipo_error')
        ->join('rechazo_departamento_responsable', 'rechazo_departamento_responsable.id', '=', 'rechazos.id_departamento_responsable')
        ->join('jobs', 'jobs.id', '=', 'rechazos.id_puesto_responsable')
        ->join('users AS coordinador', 'coordinador.id', '=', 'rechazos.id_coordinador')
        ->join('users AS productor', 'productor.id', '=', 'rechazos.id_productor')
        ->join('users AS director', 'director.id', '=', 'rechazos.id_director')
        ->join('users AS editor', 'editor.id', '=', 'rechazos.id_editor')
        ->join('users AS regrabador', 'regrabador.id', '=', 'rechazos.id_regrabador')
        ->join('episodios AS numEpisodios', 'numEpisodios.id', '=', 'rechazos.id_numero_episodio')
        ->get();
    }

    public static function guardarRechazos($request)
    {
        $rechazos = new Rechazos();

        $rechazos->fecha_rechazo = $request->input('fecha_rechazo');
        $rechazos->fecha_original_envio = $request->input('fecha_original_envio');
        $rechazos->cliente = $request->input('cliente');
        $rechazos->titulo_programa = $request->input('titulo_programa');
        $rechazos->id_episodio_temporada = $request->input('id_episodio_temporada');
        $rechazos->id_numero_episodio = $request->input('id_numero_episodio');
        $rechazos->idioma = $request->input('idioma');
        $rechazos->id_tipo_error = $request->input('id_tipo_error');
        $rechazos->id_departamento_responsable = $request->input('id_departamento_responsable');
        $rechazos->id_puesto_responsable = $request->input('id_puesto_responsable');
        $rechazos->nombre_completo_responsable = $request->input('nombre_completo_responsable');
        $rechazos->descripcion_motivo_rechazo = $request->input('descripcion_motivo_rechazo');
        $rechazos->nivel_gravedad = $request->input('nivel_gravedad');
        $rechazos->numero_rechazo = $request->input('numero_rechazo');
        $rechazos->id_coordinador = $request->input('id_coordinador');
        $rechazos->id_productor = $request->input('id_productor');
        $rechazos->id_director = $request->input('id_director');
        $rechazos->id_editor = $request->input('id_editor');
        $rechazos->id_regrabador = $request->input('id_regrabador');
        $rechazos->observaciones = $request->input('observaciones');
        $rechazos->tomar_acciones_prevencion = $request->input('tomar_acciones_prevencion');
        $rechazos->acciones_tomadas = $request->input('acciones_tomadas');
        return $rechazos->save();
    }

    public static function listaPersonalizadaRechazos($request)
    {
        echo Rechazos::select([
            'fecha_rechazo',
            'fecha_original_envio',
            'clientes.razon_social AS cliente',
            'proyectos.titulo_original AS titulo_programa',
            'proyectoTemporada.temporada AS temporada',
            'idioma',
            'rechazo_tipo_error.nombre AS tipo_error',
            'rechazo_departamento_responsable.nombre AS departamento_responsable',
            'jobs.job AS puesto_responsable',
            'nombre_completo_responsable',
            'nivel_gravedad',
            'numero_rechazo',
            'descripcion_motivo_rechazo',
            \DB::raw("CONCAT(coordinador.name,' ', coordinador.ap_paterno) AS nombre_coordinador"),
            \DB::raw("CONCAT(productor.name,' ', productor.ap_paterno) AS nombre_productor"),
            \DB::raw("CONCAT(director.name,' ', director.ap_paterno) AS nombre_director"),
            \DB::raw("CONCAT(editor.name,' ', editor.ap_paterno) AS nombre_editor"),
            \DB::raw("CONCAT(regrabador.name,' ', regrabador.ap_paterno) AS nombre_regrabador"),
            'rechazos.observaciones',
            'tomar_acciones_prevencion',
            'acciones_tomadas',
            'numEpisodios.num_episodio AS num_episodio'
            ])
        ->join('clientes', 'clientes.id', '=', 'rechazos.cliente')
        ->join('proyectos', 'proyectos.id', '=', 'rechazos.titulo_programa')
        ->join('proyectos AS proyectoTemporada', 'proyectoTemporada.id', '=', 'rechazos.id_episodio_temporada')
        ->join('episodios AS numEpisodio', 'numEpisodio.id', '=', 'rechazos.id_episodio_temporada')
        ->join('rechazo_tipo_error', 'rechazo_tipo_error.id', '=', 'rechazos.id_tipo_error')
        ->join('rechazo_departamento_responsable', 'rechazo_departamento_responsable.id', '=', 'rechazos.id_departamento_responsable')
        ->join('jobs', 'jobs.id', '=', 'rechazos.id_puesto_responsable')
        ->join('users AS coordinador', 'coordinador.id', '=', 'rechazos.id_coordinador')
        ->join('users AS productor', 'productor.id', '=', 'rechazos.id_productor')
        ->join('users AS director', 'director.id', '=', 'rechazos.id_director')
        ->join('users AS editor', 'editor.id', '=', 'rechazos.id_editor')
        ->join('users AS regrabador', 'regrabador.id', '=', 'rechazos.id_regrabador')
        ->join('episodios AS numEpisodios', 'numEpisodios.id', '=', 'rechazos.id_numero_episodio')
        ->orWhere('cliente.', 'like', '%'.$request->buscar.'%')
        ->toSql();
    }
}
