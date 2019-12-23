<?php

namespace Modules\MgProgramacionAvances\Entities;

use Illuminate\Database\Eloquent\Model;
use DB;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e', 'statusId', 'idiomaId', 'clienteId', 'viaId', 'titulo_espanol', 'titulo_ingles', 'titulo_portugues', 'adr_ingles', 'adr_portugues', 'adr_espanol', 'mix20', 'mix51', 'mix71', 'relleno_mande', 'm_e_20', 'm_e_51', 'm_e_71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'material_entregado', 'temporada', 'created_at', 'updated_at'];
    
    
    public static function getAllProjects(){
        return DB::table('proyectos')
            ->select('proyectos.created_at AS proyecto_date', 'proyectos.titulo_aprobado AS proyecto_titulo', 'clientes.razon_social AS nombre_clientes', 'episodios.num_episodio AS num_episodio', 'episodios.date_download', 'episodios.reference_download', 'episodios.notify_pistas', 'episodios.send_sebastians', 'episodios.ot', 'episodios.fecha_rayado', 'episodios.fecha_qc', 'episodios.fecha_entrega_traductor AS fecha_entrega_rayado', DB::raw("CONCAT(usproductor.name, ' ', usproductor.ap_materno, ' ', usproductor.ap_materno) AS productor ")  , 'episodios.fecha_aprobacion_cliente', DB::raw("CONCAT(usdirector.name, ' ', usdirector.ap_materno, ' ', usdirector.ap_materno) AS director "), 'salas.sala', 'episodios.date_entrega AS fecha_entrega')
            ->join('clientes', 'clientes.id', '=', 'proyectos.clienteId')
            ->join('episodios', 'episodios.proyectoId', '=', 'proyectos.id')
            ->leftjoin('users AS usproductor', 'usproductor.id', '=', 'episodios.productor')
            ->leftjoin('users AS usdirector', 'usdirector.id', '=', 'episodios.directorId')
            ->leftjoin('salas', 'salas.id', '=', 'episodios.salaId')
            ->get();
    }
}
