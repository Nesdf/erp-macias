<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;

class Episodios extends Model
{
    protected $table = 'episodios';
    protected $fillable = ['titulo_original', 'num_episodio', 'proyectoId', 'salaId', 'productor', 'responsable', 'validador_traductor', 'date_m_and_e', 'date_entrega',  'fecha_asignacion_traductor', 'fecha_entrega_traductor', 'sin_script', 'traductorId', 'fecha_doblaje', 'fecha_script','status_coordinador', 'configuracion', 'aprobacion_cliente', 'fecha_aprobacion_cliente', 'bw', 'lockcut', 'netcut', 'final', 'date_bw', 'date_lockcut', 'date_netcut', 'date_final', 'folio', 'fecha_rayado', 'rayado', 'quien_modifico_traductor', 'quien_modifico_productor', 'fecha_regrabacion', 'nombre_regrabador', 'nombre_editor', 'nombre_qc', 'fecha_qc', 'created_at', 'updated_at'];
}
