<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Episodios extends Model
{
    protected $table = 'episodios';
    protected $fillable = ['titulo_original',  'duracion', 'num_episodio', 'proyectoId', 'salaId', 'productor', 'responsable', 'validador_traductor', 'date_m_and_e', 'date_entrega',  'fecha_asignacion_traductor', 'fecha_entrega_traductor', 'script', 'traductorId', 'status_coordinador', 'configuracion', 'created_at', 'updated_at'];

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
            ->select('id', 'titulo_original', 'duracion', 'num_episodio', 'proyectoId', 'date_m_and_e', 'date_entrega', 'material_calificado')
            ->where ('proyectoId', '=', $id)
            ->get();
    }

    public static function findEpisodio($id)
    {

    	return \DB::table('episodios')
            ->join('salas', 'episodios.salaId', '=', 'salas.id')
            ->join('users as responsable', 'episodios.responsable', '=', 'responsable.id')
            ->join('users as productor', 'episodios.productor', '=', 'productor.id')
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
}
