<?php

namespace Modules\MgProyectos\Entities;

use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e', 'statusId', 'idiomaId', 'clienteId', 'viaId', 'titulo_espanol', 'titulo_ingles', 'titulo_portugues', 'adr_ingles', 'adr_portugues', 'adr_espanol', 'mix20', 'mix51', 'mix71', 'relleno_mande', 'm_e_20', 'm_e_51', 'm_e_71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'material_entregado', 'temporada', 'created_at', 'updated_at'];
	
	public static function fullProyects()
	{
		return \DB::table('proyectos')
			->join('clientes', 'proyectos.clienteId', '=', 'clientes.id')
			->select([
			'proyectos.id as id', 
			'proyectos.titulo_original as titulo_original', 
			'proyectos.titulo_aprobado as titulo_aprobado', 
			'proyectos.m_and_e as mande', 
			'clientes.razon_social as cliente',
			'proyectos.statusId as status'])
			->get();
	}

	public static function proyecto($id)
	{
		return \DB::table('proyectos')
			->where('proyectos.id', $id)
			->join('clientes', 'proyectos.clienteId', '=', 'clientes.id')
			->join('vias', 'proyectos.viaId', '=', 'vias.id')
			->select([
				'proyectos.id as id', 
				'proyectos.titulo_original as titulo_original', 
				'proyectos.titulo_aprobado as titulo_aprobado', 
				'proyectos.titulo_espanol',
				'proyectos.titulo_ingles',
				'proyectos.titulo_portugues',
				'proyectos.m_and_e as mande', 
				'clientes.razon_social as cliente',
				'proyectos.statusId as status',
				'vias.via as viaId',
				'proyectos.m_and_e',
				'proyectos.adr_espanol',
				'proyectos.adr_ingles',
				'proyectos.adr_portugues',
				'proyectos.mix20',
				'proyectos.mix51',
				'proyectos.mix71',
				'proyectos.relleno_mande',
				'proyectos.subt_espanol',
				'proyectos.subt_ingles',
				'proyectos.subt_portugues',
				'proyectos.temporada'
			])
			->get();
	}


}
