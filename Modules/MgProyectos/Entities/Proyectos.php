<?php

namespace Modules\MgProyectos\Entities;

use Illuminate\Database\Eloquent\Model;

class Proyectos extends Model
{
    protected $table = 'proyectos';
    protected $fillable = ['titulo_original', 'titulo_aprobado', 'm_and_e', 'statusId', 'idiomaId', 'clienteId', 'viaId', 'titulo_espanol', 'titulo_ingles', 'titulo_portugues', 'dobl_espanol20', 'dobl_espanol51', 'dobl_espanol71', 'dobl_ingles20', 'dobl_ingles51', 'dobl_ingles71', 'dobl_portugues20', 'dobl_portugues51', 'dobl_portugues71', 'subt_espanol', 'subt_ingles', 'subt_portugues', 'material_entregado', 'created_at', 'updated_at'];
	
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

	public static function proyecto()
	{
		return \DB::table('proyectos')
			->join('clientes', 'proyectos.clienteId', '=', 'clientes.id')
			->join('vias', 'proyectos.viaId', '=', 'vias.id')
			->select([
				'proyectos.id as id', 
				'proyectos.titulo_original as titulo_original', 
				'proyectos.titulo_aprobado as titulo_aprobado', 
				'proyectos.m_and_e as mande', 
				'clientes.razon_social as cliente',
				'proyectos.statusId as status',
				'vias.via as viaId',
				'proyectos.m_and_e',
				'proyectos.titulo_espanol',
				'proyectos.titulo_ingles',
				'proyectos.titulo_portugues',
				'proyectos.subt_espanol',
				'proyectos.subt_ingles',
				'proyectos.subt_portugues'
			])
			->get();
	}


}
