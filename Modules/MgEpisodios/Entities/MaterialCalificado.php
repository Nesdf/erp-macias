<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class MaterialCalificado extends Model
{
	protected $table = 'calificar_materiales';
    protected $fillable = ['correo_activo', 'duracion', 'tipo_reporte', 'mezcla', 'tcr', 'descripcion', 'id_episodio', 'created_at', 'updated_at'];
}
