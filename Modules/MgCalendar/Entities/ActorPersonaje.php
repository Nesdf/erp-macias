<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class ActorPersonaje extends Model
{
    protected $table = 'actor_personaje'; 
    protected $fillable = ['episodio_folio', 'personaje', 'fijo', 'proyecto', 'created_at', 'updated_at'];


    public static function getExiste($personaje, $folio)
    {
    	$data = \DB::table('actor_personaje')
            ->where('episodio_folio', '=', $folio)
            ->where('personaje', '=', $personaje)
            ->select('id')
            ->get();

        return (count($data) > 0) ? true : false;
    }
}
