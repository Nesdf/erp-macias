<?php

namespace Modules\MgContabilidad\Entities;

use Illuminate\Database\Eloquent\Model;

class Salas extends Model
{
    protected $table = 'salas';
    protected $fillable = ['sala', 'estudio_id', 'created_at', 'updated_at'];

    public static function salasAll()
   {
   	return \DB::select(\DB::raw('SELECT salas.id, salas.sala, estudios.estudio as estudio_id FROM salas INNER JOIN estudios ON salas.estudio_id = estudios.id'));
   } 
}
