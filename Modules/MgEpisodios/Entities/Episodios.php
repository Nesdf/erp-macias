<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Episodios extends Model
{
    protected $table = 'episodios';
    protected $fillable = [
      'titulo_original',
      'date_entrega',
      'salaId',
      'productor',
      'responsable',
      'validador_traductor',
      'fecha_asignacion_traductor',
      'fecha_entrega_traductor',
      'sin_script',
      'status_coordinador',
      'traductorId',
      'num_episodio',
      'proyectoId',
      'date_m_and_e',
      'material_calificado',
      'configuracion',
      'bw',
      'netcut',
      'lockcut',
      'final',
      'date_bw',
      'date_netcut',
      'date_lockcut',
      'date_final',
      'rayado',
      'folio',
      'directorId',
      'quien_modifico_productor',
      'quien_modifico_traductor',
      'fecha_script',
      'aprobacion_cliente',
      'fecha_aprobacion_cliente',
      'fecha_rayado',
      'fecha_doblaje',
      'chk_canciones',
      'chk_subtitulos',
      'chk_lenguaje_diferente_original',
      'chk_qc',
      'chk_reprobacion',
      'chk_edicion',
      'fecha_edicion',
      'nombre_editor',
      'fecha_regrabacion',
      'nombre_regrabador',
      'nombre_qc',
      'fecha_qc',
      'observaciones_traductor',
      'sincronia',
      'ingeniero_audio_id',
      'hiss',
      'comentarios_observaciones',
      'created_at',
      'updated_at'];

    /*public static function allEpisodioOfProject($id)
    {

    	return \DB::table('episodios')
    		->select('id', 'titulo_original', 'titulo_espanol', 'titulo_ingles', 'titulo_portugues', 'duracion', 'num_episodio', 'viaId', 'proyectoId', 'observaciones', 'date_m_and_e', 'date_entrega', 'dobl_espanol20', 'dobl_espanol51', 'dobl_espanol71', 'dobl_ingles20', 'dobl_ingles51', 'dobl_ingles71', 'dobl_portugues20', 'dobl_portugues51', 'dobl_portugues71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'material_calificado')
    		->where ('proyectoId', '=', $id)
    		->get();
    }*/
    public static function allEpisodioOfProject($id)
    {

        return \DB::table('episodios')
            ->select('id', 'titulo_original', 'status_coordinador', 'num_episodio', 'proyectoId', 'date_m_and_e', 'date_entrega', 'material_calificado', 'bw', 'netcut', 'lockcut', 'final', 'date_bw', 'date_netcut', 'date_lockcut', 'date_final', 'quien_modifico_productor', 'quien_modifico_traductor')
            ->where ('proyectoId', '=', $id)
            ->get();
    }

    public static function findEpisodio($id)
    {
    	return \DB::table('episodios')
            ->leftJoin('salas', 'episodios.salaId', '=', 'salas.id')
            ->leftJoin('users as responsable', 'episodios.responsable', '=', 'responsable.id')
            ->leftJoin('users as productor', 'episodios.productor', '=', 'productor.id')
            ->select('episodios.*',  'salas.sala as salaId', 'responsable.name as responsable', 'responsable.ap_paterno as responsable_ap_paterno', 'responsable.ap_materno as responsable_ap_materno', 'productor.name as productor', 'productor.ap_paterno as productor_ap_paterno', 'productor.ap_materno as productor_ap_materno')
            ->where ('episodios.id', '=', $id)
            ->get();
    }

    public static function eliminarCalificacion($id)
    {
        return \DB::select( \DB::raw(' DELETE FROM calificar_materiales WHERE id_episodio = ' . $id) );
    }

    public static function jobYesterdayDate()
    {
        $ayer = \Carbon\carbon::yesterday()->toDateString();

       return \DB::select(\DB::raw("SELECT proyectos.titulo_original as pro_titulo, episodios.titulo_original as  epi_titulo, episodios.date_entrega as epi_entrega FROM proyectos INNER JOIN episodios  ON episodios.\"proyectoId\" = proyectos.id WHERE episodios.date_entrega = '$ayer'" ));
    }

     public static function jobTomorrowDate()
    {
       $manana = \Carbon\carbon::tomorrow()->toDateString();

       return \DB::select(\DB::raw("SELECT proyectos.titulo_original as pro_titulo, episodios.titulo_original as  epi_titulo, episodios.date_entrega as epi_entrega FROM proyectos INNER JOIN episodios  ON episodios.\"proyectoId\" = proyectos.id WHERE episodios.date_entrega = '$manana'" ));
    }

    public static function searchFolio($folio)
    {
        $search = \DB::table('episodios')->where('folio', '=', $folio)->get();
        return (count($search) > 0) ? true : true;
    }
}
