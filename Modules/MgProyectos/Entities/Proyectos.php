<?php

namespace Modules\MgProyectos\Entities;

use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e', 'statusId', 'idiomaId', 'clienteId', 'created_at', 'updated_at'];
	
	/*public static function clientes_relation()
	{
		return \DB::table('proyectos')
			->join('idiomas', 'proyectos.idiomaId', '=', 'idiomas.id')
			->join('clientes', 'proyectos.clienteId', '=', 'clientes.id')
			->select([
			'proyectos.id as id', 
			'proyectos.titulo_original as titulo_original', 
			'proyectos.titulo_aprobado as titulo_aprobado', 
			'proyectos.m_and_e as mande', 
			'idiomas.idioma as idioma',
			'clientes.razon_social as cliente',
			'proyectos.statusId as status'])
			->get();
	}*/
}
