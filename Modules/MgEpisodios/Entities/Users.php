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
}
