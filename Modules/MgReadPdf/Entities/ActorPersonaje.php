<?php

namespace Modules\MgReadPdf\Entities;

use Illuminate\Database\Eloquent\Model;

class ActorPersonaje extends Model
{
    protected $table = 'actor_personaje'; 
    protected $fillable = ['id', 'episodio_folio', 'personaje', 'fijo', 'loops', 'proyecto', 'created_at', 'updated_at'];


    
}
