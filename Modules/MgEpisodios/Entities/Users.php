<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	protected $table = "users";
    protected $fillable = ['name', 'email', 'job', 'ap_paterno', 'ap_materno', 'tipo_empleado', 'created_at', 'updated_at'];

    public static function Productores()
    {
    	$jobs = \Modules\MgEpisodios\Entities\Jobs::where('job', 'Productor')->get();

    	return \Modules\MgEpisodios\Entities\Users::where('job', $jobs[0]->id)->get();
    }

    public static function Directores()
    {

        return \DB::table('users')
        ->join('jobs', 'users.job', '=', 'jobs.id')
        ->where('jobs.job', '=', 'Director')
        ->select('users.id','users.name', 'users.ap_paterno', 'users.ap_materno')
        ->get();
    }

    public static function Responsables()
    {
			//Respaldo no borrar
    	/*return \DB::select( \DB::raw('SELECT name, ap_paterno, ap_materno, id FROM users
WHERE name IN(\'Héctor\', \'Hector\', \'Lorena\', \'Lorena\', \'Alexandro\', \'Pedro Matthiesen\', \'Fabio\') AND ap_paterno IN(\'Solís\', \'Solis\', \'Mejía\', \'Mejia\', \'Galina\', \'Matthiesen Matthiesen\', \'Fabio\')'));*/
return \DB::select( \DB::raw('SELECT name, ap_paterno, ap_materno, id FROM users
WHERE name IN(\'Héctor\', \'Hector\', \'Lorena\', \'Lorena\', \'Alexandro\', \'Pedro Matthiesen\', \'Fabio\')'));
    }

    public static function Traductores()
    {
        return \DB::table('users')
            ->join('jobs', 'users.job', '=', 'jobs.id')
            ->where('jobs.job', 'Traductor')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'jobs.job',
                'users.ap_paterno',
                'users.ap_materno'])
            ->get();
    }

    public static function Tecnicos()
    {
        return \DB::table('users')
            ->join('jobs', 'users.job', '=', 'jobs.id')
            ->where('users.tipo_empleado', 1)
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'jobs.job',
                'users.ap_paterno',
                'users.ap_materno'])
            ->get();
    }
}
