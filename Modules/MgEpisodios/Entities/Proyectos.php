<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e','salaId', 'statusId', 'idiomaId', 'clienteId', 'created_at', 'updated_at','ingeniero_audio_id'];

    public static function allProyect($id_episodio, $id_proyecto)
    {
        return \DB::select(\DB::raw('
            SELECT episodios.*, episodios.id AS episodio_id, salas.*,  calificar_materiales.*, CONCAT(us1.name, \' \', us1.ap_paterno, \' \', us1.ap_materno) AS ingeniero_audio_name, CONCAT(us2.name, \' \', us2.ap_paterno, \' \', us2.ap_materno) AS director, estudios.*, proyectos.*, proyectos.titulo_original as titulo_proyecto, episodios.titulo_original as titulo_episodio,  episodios.date_entrega as fecha_entrega, episodios.num_episodio as num_episodio, calificar_materiales.*, tcrs.tcr as tcr2 FROM  proyectos 
            INNER JOIN episodios ON proyectos.id = episodios."proyectoId" 
            INNER JOIN calificar_materiales ON episodios.id = calificar_materiales.id_episodio 
            INNER JOIN salas ON salas.id = episodios."salaId"
            INNER JOIN estudios ON estudios.id = salas.estudio_id
            LEFT JOIN users us1 ON us1.id = episodios.ingeniero_audio_id
            LEFT JOIN users us2 ON us2.id = episodios."directorId"
            INNER JOIN tcrs ON calificar_materiales.tcr = tcrs.id  WHERE proyectos.id = '.$id_proyecto.' AND episodios.id ='. $id_episodio
        ));
    }
}
