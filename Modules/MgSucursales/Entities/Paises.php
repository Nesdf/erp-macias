<?php

namespace Modules\MgSucursales\Entities;

use Illuminate\Database\Eloquent\Model;

class Paises extends Model
{
	protected $table = "paises";
    protected $fillable = ['pais'];

    public static function Sucursales()
    {
    	return \DB::table('paises')
    		->join('estados', 'paises.id', '=', 'estados.paisesId')
    		->select('paises.pais', 'estados.estado', 'estados.id as id')
    		->groupBy('paises.pais', 'estados.estado', 'estados.id')
    		->get();
    }
}
