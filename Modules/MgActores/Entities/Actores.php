<?php

namespace Modules\MgActores\Entities;

use Illuminate\Database\Eloquent\Model;

class Actores extends Model
{
	protected $table = 'actores';
    protected $fillable = ['nombre_completo', 'nombre_artistico', 'rfc', 'created_at', 'updated_at'];

    public static function getId($nombre_completo)
	{
		return $id= \DB::select( \DB::raw("SELECT id FROM actores WHERE nombre_completo = '".$nombre_completo."' LIMIT 1") );
		
	}
}