<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Globals\Config as Config;

class Llamados extends Model
{
	protected $table = 'calendario';
    protected $fillable = ['actor', 'director', 'cita_start', 'cita_end', 'folio', 'descripcion', 'estatus_grupo', 'estatus', 'sala', 'credencial', 'loops', 'capitulo', 'created_at', 'updated_at'];


    public static function listaLlamados($sala)
    {
    	return \DB::select(\DB::raw("SELECT id, loops, director, credencial, pago_total_loops, cita_start, cita_end, descripcion AS descr, actor AS title, CASE WHEN actor IS NOT NULL THEN 'label-success' END AS \"className\", CASE WHEN actor IS NOT NULL THEN actor ||'<br> Entrada: ' || cita_start::time ||'</span> <br> '|| 'Salida: ' || cita_end::time END AS descripcion, cita_end AS start, cita_end as end FROM calendario WHERE sala='$sala'"));
    }

    public static function allLlamados($sala, $date)
    {
        return \DB::select(\DB::raw("SELECT  actor, director, folio, sala, pago_total_loops, loops, credencial, descripcion AS descr,
        (SELECT estudio FROM estudios where id = (SELECT estudio_id FROM salas where sala = '".$sala."')) AS estudio,
        CASE WHEN actor IS NOT NULL THEN  cita_start::time  END AS entrada,
        CASE WHEN actor IS NOT NULL THEN cita_end::time END AS salida,
        CASE WHEN actor IS NOT NULL THEN cita_end::date END AS fecha
        FROM calendario
        WHERE  cita_end::text LIKE '%".$date."%' AND sala='".$sala."'"));

    }

    public static function EntreFechas($dateInicial, $dateFinal, $sala)
    {
        return \DB::select(\DB::raw("SELECT * FROM calendario where cita_start BETWEEN '".$dateInicial."' AND '".$dateFinal."' AND sala = '".$sala."' OR cita_end BETWEEN '".$dateInicial."' AND '".$dateFinal."' AND sala = '".$sala."' "));
    }

    public static function getAllActores($folio, $fecha_inicio, $fecha_fin)
    {
        return \DB::select(\DB::raw("SELECT * FROM calendario WHERE folio = '".$folio."'
 				AND cita_end >= '".$fecha_inicio." 00:00:00' AND cita_end <= '".$fecha_fin." 23:59:00' AND estatus_llamado = '".Config::RTK."' "));
    }

		public static function allRegisters($lunes, $sabado)
		{
			return \DB::select(\DB::raw("SELECT * FROM calendario WHERE cita_end BETWEEN '".$lunes."' AND '".$sabado."'"));
		}

		public static function allIntRegisters($lunes, $sabado)
		{
			return \DB::select(\DB::raw("SELECT actor FROM calendario WHERE cita_end BETWEEN '".$lunes."' AND '".$sabado."' GROUP BY actor"));
		}
}
