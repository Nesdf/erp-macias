<?php

namespace Modules\MgPersonal\Entities;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	//Tipo_empleado: 1 = Técnico; 0 = Administrativo
	protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'job', 'ap_paterno', 'ap_materno', 'tipo_empleado', 'password', 'lista_estudios', 'created_at', 'updated_at'];
	protected $hidden = ['password'];

	public static function Personal()
	{
		return \DB::table('users')
			->join('jobs', 'users.job', '=', 'jobs.id')
			->select([
				'users.id',
				'users.name', 
				'users.email', 
				'users.lista_estudios',
				'jobs.job', 
				'users.ap_paterno', 
				'users.ap_materno'])
			->get();
	}

	public static function Empleado($id)
	{
		return \DB::table('users')
			->join('jobs', 'users.job', '=', 'jobs.id')
			->where('users.id', $id)
			->select([
				'users.id',
				'users.name', 
				'users.email', 
				'jobs.job', 
				'users.ap_paterno', 
				'users.ap_materno'])
			->get();
	}

	public static function verificarEstudios($estudios)
	{
		return User::where('lista_estudios', '=', $estudios)->exists();
	}
}
