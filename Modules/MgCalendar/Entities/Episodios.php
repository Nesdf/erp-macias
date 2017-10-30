<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Episodios extends Model
{
	protected $table = 'episodios';
    protected $fillable = ['titulo_original', 'num_episodio', 'proyectoId', 'salaId', 'productor', 'responsable', 'validador_traductor', 'date_m_and_e', 'date_entrega',  'fecha_asignacion_traductor', 'fecha_entrega_traductor', 'script', 'traductorId', 'status_coordinador', 'configuracion', 'bw', 'lockcut', 'netcut', 'final', 'date_bw', 'date_lockcut', 'date_netcut', 'date_final', 'created_at', 'updated_at'];

    public static function listEpisodios($id)
    {
    	return \DB::table('episodios')
			->where('proyectoId', '=', $id)
			->where('salaId', '!=', null)
			->get();
    }

}
