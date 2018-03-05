<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Globals\Config as Config;

class Episodios extends Model
{
    protected $table = 'episodios';
    protected $fillable = ['titulo_original', 'num_episodio', 'proyectoId', 'salaId', 'productor', 'responsable', 'validador_traductor', 'date_m_and_e', 'date_entrega',  'fecha_asignacion_traductor', 'fecha_entrega_traductor', 'sin_script', 'traductorId', 'fecha_doblaje', 'fecha_script','status_coordinador', 'configuracion', 'aprobacion_cliente', 'fecha_aprobacion_cliente', 'bw', 'lockcut', 'netcut', 'final', 'date_bw', 'date_lockcut', 'date_netcut', 'date_final', 'folio', 'fecha_rayado', 'rayado', 'quien_modifico_traductor', 'quien_modifico_productor', 'fecha_regrabacion', 'nombre_regrabador', 'nombre_editor', 'nombre_qc', 'fecha_qc', 'created_at', 'updated_at'];


    public static function allEpisodios($lunes, $sabado, $salas)
    {
        return \DB::select(\DB::raw('SELECT titulo_original, num_episodio, folio,
          (SELECT titulo_original FROM proyectos where id = episodios."proyectoId" ) AS titulo_proyecto,
          (SELECT CASE WHEN sum(cast(pago_total_loops as float)) IS NULL THEN 0 ELSE SUM(cast(pago_total_loops as float)) END  FROM calendario WHERE  sala IN('.$salas.') AND folio = episodios.folio
          AND cita_end >= \''.$lunes.'\' AND cita_end <= \''.$sabado.'\' AND estatus= true AND estatus_llamado = \''.Config::RTK.'\') AS total
          FROM episodios WHERE (SELECT sum(cast(pago_total_loops as float)) FROM calendario WHERE folio = episodios.folio
          AND cita_end >= \''.$lunes.'\' AND cita_end <= \''.$sabado.'\') IS NOT NULL '));

    }

    public static function getAllById($id_proyecto)
    {
      //return \DB::select(\DB::raw("SELECT * FROM episodios WHERE \"proyectoId\" = '".$id_proyecto."'"));
      return \DB::select(\DB::raw("SELECT E.titulo_original, E.num_episodio, E.folio, (SELECT  CASE WHEN SUM(cast(C.pago_total_loops as float)) IS NULL THEN 0 ELSE SUM(cast(C.pago_total_loops as float)) END FROM calendario AS C WHERE E.folio=C.folio)
      FROM episodios AS E WHERE E.\"proyectoId\" = '".$id_proyecto."'"));
    }

    public static function getNameEpisodio($folio){
      return \DB::select(\DB::raw("SELECT * FROM episodios WHERE folio = '".$folio."' LIMIT 1"));
    }
}
