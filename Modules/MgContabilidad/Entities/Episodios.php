<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Globals\Config as Config;

class Episodios extends Model
{
    protected $table = 'episodios';
    protected $fillable = ['titulo_original', 'num_episodio', 'proyectoId', 'salaId', 'productor', 'responsable', 'validador_traductor', 'date_m_and_e', 'date_entrega',  'fecha_asignacion_traductor', 'fecha_entrega_traductor', 'sin_script', 'traductorId', 'fecha_doblaje', 'fecha_script','status_coordinador', 'configuracion', 'aprobacion_cliente', 'fecha_aprobacion_cliente', 'bw', 'lockcut', 'netcut', 'final', 'date_bw', 'date_lockcut', 'date_netcut', 'date_final', 'folio', 'fecha_rayado', 'rayado', 'quien_modifico_traductor', 'quien_modifico_productor', 'fecha_regrabacion', 'nombre_regrabador', 'nombre_editor', 'nombre_qc', 'fecha_qc', 'created_at', 'updated_at'];


    public static function allEpisodios($lunes, $sabado)
    {
        return \DB::select(\DB::raw('SELECT titulo_original, num_episodio, folio,
          (SELECT titulo_original FROM proyectos where id = episodios."proyectoId" ) AS titulo_proyecto,
          (SELECT sum(cast(pago_total_loops as float)) FROM calendario WHERE folio = episodios.folio
          AND cita_end >= \''.$lunes.' 00:00:00\' AND cita_end <= \''.$sabado.' 23:59:00\' AND estatus_llamado = \''.Config::RTK.'\') AS total
          FROM episodios WHERE (SELECT sum(cast(pago_total_loops as float)) FROM calendario WHERE folio = episodios.folio
          AND cita_end >= \''.$lunes.' 00:00:00\' AND cita_end <= \''.$sabado.' 23:59:00\') IS NOT NULL '));

    }

    public static function getAllById($id_proyecto)
    {
      return \DB::select(\DB::raw("SELECT * FROM episodios WHERE \"proyectoId\" = '".$id_proyecto."'"));
    }
}
