<?php

namespace Modules\MgPuestos\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\MgPersonal\Entities\User;

class Puestos extends Model
{
    protected $table = 'jobs';
    protected $fillable = ['job', 'created_at', 'updated_at'];

    public static function editores()
    {
        return User::select('users.*', 'jobs.*')
        ->join('jobs', 'users.job','=', 'jobs.id')
        ->get();
    }
}