<?php

namespace Modules\MgReadPdf\Entities;

use Illuminate\Database\Eloquent\Model;

class ActorPersonaje extends Model
{
    protected $table = 'actor_personaje'; 
    protected $fillable = ['id', 'episodio_folio', 'personaje', 'fijo', 'loops', 'proyecto', 'asignado',  'created_at', 'updated_at'];

    public static function getPersonajesByEpisodio($folio){
		return \DB::table('actor_personaje')
		->select('*')
		->where('actor_personaje.episodio_folio', '=', $folio)
		->get();
	}

    
}
