<?php

namespace Modules\MgCalendar\Entities;

use Illuminate\Database\Eloquent\Model;

class Actores extends Model
{
	protected $table = 'actores'; 
    protected $fillable = ['nombre_completo', 'nombre_artistico', 'created_at', 'updated_at'];

    public static function Directores()
    {
        return \DB::table('users')
            ->join('jobs', 'users.job', '=', 'jobs.id')
            ->where('jobs.job', 'Director')
            ->select([
                'users.id',
                'users.name', 
                'users.email', 
                'jobs.job', 
                'users.ap_paterno', 
                'users.ap_materno'])
            ->get();
    }

    public static function credencialesActores($id)
    {
        return \DB::table('folio_actores')
            ->where('actor_id', '=', $id)
            ->select('folio')
            ->get();
    }
}
