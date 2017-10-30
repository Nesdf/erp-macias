<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Llamados extends Model
{
	protected $table = 'calendario';
    protected $fillable = ['actor', 'director', 'cita_start', 'cita_end', 'folio', 'descripcion', 'estatus_grupo', 'estatus', 'created_at', 'updated_at'];


    public static function listaLlamados()
    {
    	return \DB::table('calendario')
            ->select('actor as title', 'cita_end as start', 'cita_end as end')
            ->get();
    }
}
