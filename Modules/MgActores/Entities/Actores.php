<?php

namespace Modules\MgActores\Entities;

use Illuminate\Database\Eloquent\Model;

class Actores extends Model
{
	protected $table = 'actores';
    protected $fillable = ['nombre_completo', 'nombre_artistico', 'rfc', 'created_at', 'updated_at'];
}
