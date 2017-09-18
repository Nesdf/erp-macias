<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e', 'statusId', 'idiomaId', 'clienteId', 'created_at', 'updated_at'];

    public static function allProyect($id_episodio, $id_proyecto)
    {
        return \DB::select(\DB::raw('
            SELECT proyectos.titulo_original as titulo_proyecto, episodios.titulo_original as titulo_episodio,  episodios.date_entrega as fecha_entrega, calificar_materiales.* FROM  proyectos INNER JOIN episodios ON proyectos.id = episodios."proyectoId" INNER JOIN calificar_materiales ON episodios.id = calificar_materiales.id_episodio WHERE proyectos.id = '.$id_proyecto.' AND episodios.id = '. $id_episodio
            ));
    }
}
