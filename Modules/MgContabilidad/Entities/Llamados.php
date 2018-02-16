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
    	return \DB::select(\DB::raw("SELECT id, loops, director, credencial, pago_total_loops, cita_start, cita_end, descripcion AS descr, actor AS title, CASE WHEN actor IS NOT NULL THEN 'label-success' END AS \"className\", CASE WHEN actor IS NOT NULL THEN actor ||'<br> Entrada: ' || cita_start::time ||'</span> <br> '|| 'Salida: ' || cita_end::time END AS descripcion, cita_end AS start, cita_end as end FROM calendario WHERE sala='$sala' AND estatus= true"));
    }

    public static function allLlamados($sala, $date)
    {
        return \DB::select(\DB::raw("SELECT  actor, director, folio, nombre_real, sala, pago_total_loops, loops, credencial, descripcion AS descr,
        (SELECT estudio FROM estudios where id = (SELECT estudio_id FROM salas where sala = '".$sala."')) AS estudio,
        CASE WHEN actor IS NOT NULL THEN  cita_start::time  END AS entrada,
        CASE WHEN actor IS NOT NULL THEN cita_end::time END AS salida,
        CASE WHEN actor IS NOT NULL THEN cita_end::date END AS fecha
        FROM calendario
        WHERE  cita_end::text LIKE '%".$date."%' AND sala='".$sala."' AND estatus_llamado = '".Config::RTK."' AND estatus= true"));

    }

    public static function EntreFechas($dateInicial, $dateFinal, $sala)
    {
        return \DB::select(\DB::raw("SELECT * FROM calendario WHERE cita_end >= '".$dateInicial."' AND cita_end <= '".$dateFinal."' AND sala = '".$sala."' OR cita_end >= '".$dateInicial."' AND cita_end <= '".$dateFinal."' AND sala = '".$sala."' AND estatus_llamado = '".Config::RTK."' AND estatus= true"));
    }

    public static function getAllActores($folio, $fecha_inicio, $fecha_fin)
    {
        return \DB::select(\DB::raw("SELECT * FROM calendario WHERE folio = '".$folio."'
 				AND cita_end >= '".$fecha_inicio." 00:00:00' AND cita_end <= '".$fecha_fin." 23:59:00' AND estatus_llamado = '".Config::RTK."' AND estatus= true"));
    }

		public static function allRegisters($lunes, $sabado)
		{
			return \DB::select(\DB::raw("SELECT * FROM calendario WHERE estatus_llamado = '".Config::RTK."' AND estatus= true AND cita_end >= '".$lunes."' AND cita_end <= '".$sabado."' "));
		}

		public static function allIntRegisters($lunes, $sabado)
		{
			return \DB::select(\DB::raw("SELECT actor FROM calendario WHERE  estatus_llamado = '".Config::RTK."' AND estatus= true AND  cita_end >= '".$lunes."' AND cita_end <= '".$sabado."' GROUP BY actor"));
		}



		public static function getDetalleActores($fecha_inicial, $fecha_final)
		{
			return \DB::select(\DB::raw("SELECT C.nombre_real, C.actor, C.cita_end, C.loops, C.pago_total_loops, E.num_episodio, P.titulo_original
				FROM calendario AS C
				INNER JOIN episodios AS E ON E.folio = C.folio
				INNER JOIN proyectos AS P ON P.id = E.\"proyectoId\"
				WHERE C.cita_start >= '".$fecha_inicial."' AND C.cita_end <= '".$fecha_final."' AND estatus_llamado = '".Config::RTK."' AND estatus= true"));
		}

		public static function getProyecto($folio)
		{
			return \DB::select(\DB::raw("SELECT E.\"proyectoId\", P.titulo_original FROM episodios AS E INNER JOIN proyectos AS P ON P.id = E.\"proyectoId\" WHERE folio = '".$folio."'"));
		}
}
