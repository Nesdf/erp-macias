<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e', 'statusId', 'idiomaId', 'clienteId', 'viaId', 'titulo_espanol', 'titulo_ingles', 'titulo_portugues', 'adr_ingles', 'adr_portugues', 'adr_espanol', 'mix20', 'mix51', 'mix71', 'relleno_mande', 'm_e_20', 'm_e_51', 'm_e_71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'material_entregado', 'temporada', 'created_at', 'updated_at'];

    public static function allProyects($folios){

        return \DB::table('proyectos')
            ->join('episodios', 'proyectos.id', '=', 'episodios.proyectoId')
            ->whereIn('episodios.folio',  $folios)
            ->select('proyectos.titulo_original as proyectos', 'episodios.titulo_original as episodios','episodios.folio as folios', 'episodios.num_episodio as capitulo' )
            ->get();
    }
}
