<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Episodios extends Model
{
    protected $table = 'episodios';
    protected $fillable = ['titulo_original', 'titulo_espanol', 'duracion', 'num_episodio', 'viaId', 'proyectoId', 'observaciones', 'date_m_and_e', 'date_entrega', 'dobl_espanol20', 'dobl_espanol51', 'dobl_espanol71', 'dobl_ingles20', 'dobl_ingles51', 'dobl_ingles71', 'dobl_portugues20', 'dobl_portugues51', 'dobl_portugues71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'created_at', 'updated_at'];

    public static function allEpisodioOfProject($id)
    {

    	return \DB::table('episodios')
    		->select('id', 'titulo_original', 'titulo_espanol', 'titulo_ingles', 'titulo_portugues', 'duracion', 'num_episodio', 'viaId', 'proyectoId', 'observaciones', 'date_m_and_e', 'date_entrega', 'dobl_espanol20', 'dobl_espanol51', 'dobl_espanol71', 'dobl_ingles20', 'dobl_ingles51', 'dobl_ingles71', 'dobl_portugues20', 'dobl_portugues51', 'dobl_portugues71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'material_calificado')
    		->where ('proyectoId', '=', $id)
    		->get();
    }

    public static function findEpisodio($id)
    {

    	return \DB::table('episodios')
            ->join('vias', 'episodios.viaId', '=', 'vias.id')
            ->select('episodios.*', 'vias.via as viaId' )
            ->where ('episodios.id', '=', $id)
            ->get();
    }

    public static function eliminarCalificacion($id)
    {
        return \DB::select( \DB::raw(' DELETE FROM calificar_materiales WHERE id_episodio = ' . $id) );
    }
}
