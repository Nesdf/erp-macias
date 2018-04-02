<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Globals\Config;

class Llamados extends Model
{
	protected $table = 'calendario';
    protected $fillable = ['actor', 'director', 'cita_start', 'cita_end', 'folio', 'descripcion', 'estatus_grupo', 'estatus', 'sala', 'credencial', 'loops', 'capitulo', 'estatus_llamado', 'pago_total_loops', 'id_llamado_reagendado', 'descripcion_reagenda', 'estatus_reagenda', 'nombre_real', 'estatus_pago', 'created_at', 'updated_at'];


    public static function listaLlamados($sala)
    {
    	return \DB::select(\DB::raw("SELECT id, loops, director, credencial, cita_start, cita_end, descripcion AS descr, actor AS title, CASE WHEN actor IS NOT NULL THEN 'label-success' END AS \"className\", CASE WHEN actor IS NOT NULL THEN actor ||'<br> Entrada: ' || cita_start::time ||'</span> <br> '|| 'Salida: ' || cita_end::time END AS descripcion, cita_end AS start, cita_end as end FROM calendario WHERE sala='".$sala."' AND estatus= true  AND estatus_llamado = '".Config::RTK."' "));
    }

    public static function allLlamados($sala, $date)
    {
        return \DB::select(\DB::raw("SELECT  actor, director, folio, sala, loops, credencial, descripcion AS descr,
        (SELECT estudio FROM estudios where id = (SELECT estudio_id FROM salas where sala = '".$sala."')) AS estudio,
        CASE WHEN actor IS NOT NULL THEN  cita_start::time  END AS entrada,
        CASE WHEN actor IS NOT NULL THEN cita_end::time END AS salida,
        CASE WHEN actor IS NOT NULL THEN cita_end::date END AS fecha
        FROM calendario
        WHERE  cita_end::text LIKE '%".$date."%' AND sala='".$sala."' AND estatus = true AND  estatus_llamado = '".Config::RTK."'
				ORDER BY cita_end DESC"));

    }

    public static function EntreFechas($dateInicial, $dateFinal, $sala)
    {
        return \DB::select(\DB::raw("SELECT * FROM calendario where cita_start BETWEEN '".$dateInicial."' AND '".$dateFinal."' AND sala = '".$sala."' OR cita_end BETWEEN '".$dateInicial."' AND '".$dateFinal."' AND sala = '".$sala."' AND estatus_llamado = '".Config::RTK."' AND estatus= true "));
    }

    public static function ActorLlamado($texto)
    {
        return $texto;
    }

    public static function getLlamados($actor, $fecha)
    {
        return \DB::select(\DB::raw("SELECT * FROM calendario where cita_end::text LIKE '%".$fecha."%'  AND actor = '".$actor."'  AND estatus_llamado = '".Config::RTK."' AND estatus= true "));
    }

    public static function eliminarLlamado($id)
    {
        return \DB::select(\DB::raw("UPDATE calendario SET estatus = false where id= ".$id." "));
    }

    public static function existeLlamadoHoy($actor, $sala, $fecha, $hora_entrada, $hora_salida)
    {
       //return \DB::select(\DB::raw("SELECT * FROM calendario where actor = '".$actor."' AND sala != '".$sala."' AND cita_end::text like '%".$fecha."%'"));
			 return \DB::select(\DB::raw("SELECT * FROM calendario WHERE actor = '".$actor."' AND sala != '".$sala."' AND cita_end >= '".$fecha." ".$hora_entrada."' AND cita_end <= '".$fecha." ".$hora_salida."' AND estatus_llamado = '".Config::RTK."' AND estatus= true "));

    }
}
