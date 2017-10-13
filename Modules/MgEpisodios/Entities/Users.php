<?php

namespace Modules\MgEpisodios\Entities;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
	protected $table = "users";
    protected $fillable = ['name', 'email', 'job', 'ap_paterno', 'ap_materno', 'created_at', 'updated_at'];

    public static function Productores()
    {
    	$jobs = \Modules\MgEpisodios\Entities\Jobs::where('job', 'Productor')->get();

    	return \Modules\MgEpisodios\Entities\Users::where('job', $jobs[0]->id)->get();
    }

    public static function Responsables()
    {
    	return \DB::select( \DB::raw('select name, ap_paterno, ap_materno, id from users
where name in(\'Héctor\', \'Lorena\', \'Alexandro\') AND ap_paterno in(\'Solís\', \'Mejía\', \'Galina\')'));
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
}
