<?php

namespace Modules\MgClientes\Entities;

use Illuminate\Database\Eloquent\Model;

class clientes extends Model
{
    protected $table = 'clientes';
    protected $fillable = ['razon_social', 'rfc', 'paisId', 'estadoId', 'created_at', 'updated_at'];
	
	public static function clientes_relation()
	{
		
		return \DB::table('clientes')
			->join('paises', 'clientes.paisId', '=', 'paises.id')
			->join('estados', 'clientes.estadoId', '=', 'estados.id')
			->select([
			'clientes.id as id', 
			'clientes.razon_social as razon_social', 
			'clientes.rfc as rfc', 
			'clientes.paisId as paisId', 
			'clientes.estadoId as estadoId',
			'paises.pais as pais',
			'estados.estado as estado'])
			->get();
	}
}
