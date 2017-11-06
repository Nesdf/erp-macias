<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Llamados extends Model
{
	protected $table = 'calendario';
    protected $fillable = ['actor', 'director', 'cita_start', 'cita_end', 'folio', 'descripcion', 'estatus_grupo', 'estatus', 'sala', 'credencial', 'loops', 'capitulo', 'created_at', 'updated_at'];


    public static function listaLlamados($sala)
    {
    	return \DB::select(\DB::raw("SELECT id, loops, director, credencial, cita_start, cita_end, descripcion AS descr, actor AS title, CASE WHEN actor IS NOT NULL THEN 'label-success' END AS \"className\", CASE WHEN actor IS NOT NULL THEN actor ||'<br> Entrada: ' || cita_start::time ||'</span> <br> '|| 'Salida: ' || cita_end::time END AS descripcion, cita_end AS start, cita_end as end FROM calendario WHERE sala='$sala'"));
    }

    public static function allLlamados($sala, $date)
    {
        return \DB::select(\DB::raw("SELECT id, actor, director, folio, sala, loops, credencial, descripcion AS descr, 
        (SELECT estudio FROM estudios where id = (SELECT estudio_id FROM salas where sala = '".$sala."')) AS estudio,
        CASE WHEN actor IS NOT NULL THEN  cita_start::time  END AS entrada, 
        CASE WHEN actor IS NOT NULL THEN cita_end::time END AS salida, 
        CASE WHEN actor IS NOT NULL THEN cita_end::date END AS fecha 
        FROM calendario 
        WHERE  cita_start::text LIKE '%".$date."%' AND sala='".$sala."'"));

    }
}
