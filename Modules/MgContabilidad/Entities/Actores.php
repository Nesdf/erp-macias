<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;

class Actores extends Model
{
		protected $table = 'actores';
    protected $fillable = ['nombre_completo', 'nombre_artistico', 'created_at', 'updated_at'];
}
